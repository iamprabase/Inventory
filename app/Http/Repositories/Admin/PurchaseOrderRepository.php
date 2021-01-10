<?php

namespace App\Http\Repositories\Admin;

use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Http\Repositories\BaseRepository;
use App\Http\Contracts\Admin\PurchaseOrderContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PurchaseOrderRepository extends BaseRepository implements PurchaseOrderContract{
  
  public function __construct(PurchaseOrder $model){
    parent::__construct($model);
    $this->model = $model;
  }

  public function listAllPurchaseOrder(string $order = 'id', string $sort = 'desc', array $columns = ['*']){
    return $this->all($order, $sort, $columns);
  }

  public function listAllPurchaseOrderWithSupplier(string $order = 'id', string $sort = 'desc', array $columns = ['*']){
    return PurchaseOrder::with('supplier')->orderBy($order, $sort)->get($columns);
  }
  
  public function listTopPurchaseOrderWithSupplier(string $order = 'id', string $sort = 'desc', int $number = 5,array $columns = ['*']){
    return PurchaseOrder::with('supplier')->orderBy($order, $sort)->take($number)->get($columns);
  }

  public function createPurchaseOrder(array $attributes){
    try{
      $collection = collect($attributes);
      $purchase_order = new PurchaseOrder($collection->all());
      
      $purchase_order->save();
      
      return $purchase_order;
    }catch(QueryException $e){
      throw new QueryException($e->getMessage());
    }
  }

  public function updatePurchaseOrder(array $attributes){
    $purchase_order = $this->findPurchaseOrderById($attributes['id']);
    $collection = collect($attributes)->except('_token');

    $purchase_order->update($collection->all());

    return $purchase_order;
  }

  public function findPurchaseOrderById(int $id){
    try {
        return $this->findOrFail($id);
      } catch (ModelNotFoundException $e) {
        throw new ModelNotFoundException($e);
      }
  }

  public function findPurchaseOrderWithPurchaseDetailById(int $id){
    try {
        return PurchaseOrder::with(['purchaseOrderDetails','purchaseOrderDetails.product'])->findOrFail($id);
        
      } catch (ModelNotFoundException $e) {
        throw new ModelNotFoundException($e);
      }
  }

  public function deletePurchaseOrder(int $id){
    $purchase_order = $this->findPurchaseOrderById($id);
    // $purchase_order->purchaseOrderDetails->delete();
    $purchase_order->delete();
  }

}