<?php

namespace App\Http\Repositories\Admin;

use App\Models\StockTransfer;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Http\Repositories\BaseRepository;
use App\Http\Contracts\Admin\StockTransferContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StockTransferRepository extends BaseRepository implements StockTransferContract{
  
  public function __construct(StockTransfer $model){
    parent::__construct($model);
    $this->model = $model;
  }

  public function listAllStockTransfer(string $order = 'id', string $sort = 'desc', array $columns = ['*']){
    return $this->all($order, $sort, $columns);
  }

  public function listTopStockTransferWithSourceDestination(string $order = 'id', string $sort = 'desc', int $number = 5,array $columns = ['*']){
    return StockTransfer::with('source')->with('destination')->orderBy($order, $sort)->take($number)->get($columns);
  }

  public function listAllStockTransferWithSourceDestination(string $order = 'id', string $sort = 'desc', array $columns = ['*']){
    return StockTransfer::with('source')->with('destination')->orderBy($order, $sort)->get($columns);
  }

  public function createStockTransfer(array $attributes){
    try{
      $collection = collect($attributes);
      $purchase_order = new StockTransfer($collection->all());
      
      $purchase_order->save();
      
      return $purchase_order;
    }catch(QueryException $e){
      throw new QueryException($e->getMessage());
    }
  }

  public function updateStockTransfer(array $attributes){
    $purchase_order = $this->findStockTransferById($attributes['id']);
    $collection = collect($attributes)->except('_token');

    $purchase_order->update($collection->all());

    return $purchase_order;
  }

  public function findStockTransferById(int $id){
    try {
        return $this->findOrFail($id);
      } catch (ModelNotFoundException $e) {
        throw new ModelNotFoundException($e);
      }
  }

  public function findStockTransferWithStockTransferDetailById(int $id){
    try {
        return StockTransfer::with(['stockTransferDetails','stockTransferDetails.product'])->findOrFail($id);
        
      } catch (ModelNotFoundException $e) {
        throw new ModelNotFoundException($e);
      }
  }

  public function deleteStockTransfer(int $id){
    $purchase_order = $this->findStockTransferById($id);
    $purchase_order->delete();
  }

}