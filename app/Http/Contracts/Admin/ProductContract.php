<?php

namespace App\Http\Contracts\Admin;

interface ProductContract
{
  public function listAllProduct(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

  public function listProductInStock(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

  public function listAllProductWithBrandAndCategory(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

  public function listAllProductWithBrand(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

  public function listAllProductWithCategory(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

  public function createProduct(array $attributes);

  public function updateProduct(array $attributes);

  public function findProductById(int $id);

  public function deleteProduct(int $id);

  public function saveImage(string $image_path, string $name, int $product_id,float $image_size);
}
