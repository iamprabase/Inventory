<?php

namespace App\Http\Repositories\Admin;

use App\Models\Supplier;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Http\Repositories\BaseRepository;
use App\Http\Contracts\Admin\SupplierContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SupplierRepository extends BaseRepository implements SupplierContract{
  
  public function __construct(Supplier $model){
    parent::__construct($model);
    $this->model = $model;
  }

  public function listAllSupplier(string $order = 'id', string $sort = 'desc', array $columns = ['*']){
    return $this->all($order, $sort, $columns);
  }

  public function createSupplier(array $attributes){
    try{
      $collection = collect($attributes);
      
      $supplier = new Supplier($collection->all());

      $supplier->save();

      return $supplier;
    }catch(QueryException $e){
      throw new QueryException($e->getMessage());
    }
  }

  public function updateSupplier(array $attributes){
    $supplier = $this->findSupplierById($attributes['id']);
    $collection = collect($attributes)->except('_token');

    $supplier->update($collection->all());

    return $supplier;
  }

  public function findSupplierById(int $id){
    try {
        return $this->findOrFail($id);
      } catch (ModelNotFoundException $e) {
        throw new ModelNotFoundException($e);
      }
  }

  public function deleteSupplier(int $id){
    $supplier = $this->findSupplierById($id);

    $supplier->delete();
  }

}