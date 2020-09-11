<?php

namespace App\Http\Contracts\Admin;

interface BrandContract{
  
  public function listAllBrand(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

  public function createBrand(array $attributes);
  
  public function updateBrand(array $attributes);
  
  public function findBrandById(int $id);

  public function deleteBrand(int $id);

}