<?php

namespace App\Http\Repositories\Admin;

use App\Models\Brand;
use Illuminate\Database\QueryException;
use App\Http\Repositories\BaseRepository;
use App\Http\Contracts\Admin\BrandContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BrandRepository extends BaseRepository implements BrandContract{
  
  public function __construct(Brand $model){
    parent::__construct($model);
    $this->model = $model;
  }

  public function listAllBrand(string $order = 'id', string $sort = 'desc', array $columns = ['*']){
    return $this->all($order, $sort, $columns);
  }

  public function createBrand(array $attributes){
    try{
      $collection = collect($attributes);

      $brand = new Brand($collection->all());

      $brand->save();

      return $brand;
    }catch(QueryException $e){
      throw new QueryException($e->getMessage());
    }
  }
  
  public function updateBrand(array $attributes){
    $brand = $this->findBrandById($attributes['id']);
    $collection = collect($attributes)->except('_token');

    $brand->update($collection->all());
    
    return $brand;
  }
  
  public function findBrandById(int $id){
    try{
      return $this->findOrFail($id);
    }catch(ModelNotFoundException $e){
      throw new ModelNotFoundException($e);
    }
  }

  public function deleteBrand(int $id){
    $brand = $this->findBrandById($id);
    
    $brand->delete();
  }
}