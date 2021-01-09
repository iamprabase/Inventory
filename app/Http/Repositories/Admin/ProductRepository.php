<?php

namespace App\Http\Repositories\Admin;

use App\Models\Product;
use App\Models\ImageProduct;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Http\Repositories\BaseRepository;
use App\Http\Contracts\Admin\ProductContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRepository extends BaseRepository implements ProductContract{
  
  public function __construct(Product $model){
    parent::__construct($model);
    $this->model = $model;
  }

  public function listAllProduct(string $order = 'id', string $sort = 'desc', array $columns = ['*']){
    return $this->all($order, $sort, $columns);
  }

  public function listProductInStock(string $order = 'id', string $sort = 'desc', array $columns = ['*']){
    return Product::whereStock('In-stock')->orderBy($order, $sort)->get($columns);
  }

  public function listAllProductWithBrandAndCategory(string $order = 'id', string $sort = 'desc', array $columns = ['*']){
    return Product::with('brand')->with('category')->orderBy($order, $sort)->get($columns);
  }

  public function listAllProductWithBrand(string $order = 'id', string $sort = 'desc', array $columns = ['*']){
    return Product::with('brand')->orderBy($order, $sort)->get($columns);
  }

  public function listAllProductWithCategory(string $order = 'id', string $sort = 'desc', array $columns = ['*']){
    return Product::with('caetgory')->orderBy($order, $sort)->get($columns);
  }

  public function createProduct(array $attributes){
    try{
      $collection = collect($attributes);
      
      $product = new Product($collection->all());

      $product->save();

      return $product;
    }catch(QueryException $e){
      throw new QueryException($e->getMessage());
    }
  }

  public function updateProduct(array $attributes){
    $product = $this->findProductById($attributes['id']);
    $collection = collect($attributes)->except('_token');

    $product->update($collection->all());

    return $product;
  }

  public function findProductById(int $id){
    try {
        return $this->findOrFail($id);
      } catch (ModelNotFoundException $e) {
        throw new ModelNotFoundException($e);
      }
  }

  public function deleteProduct(int $id){
    $product = $this->findProductById($id);
    
    $product->delete();
  }

  public function saveImage(string $image_path, string $name, int $product_id, float $image_size){
    try{
      $image = ImageProduct::create([
        'product_id' => $product_id,
        'name' => $name,
        'src' => $image_path,
        'size' => $image_size
      ]);
    }catch(\Exception $e){
      $errors = array("code" => $e->getCode(), "line" => $e->getLine(), "file" => $e->getFile());
      Log::info($errors);
      Log::error($e->getMessage());
    }

  }
}