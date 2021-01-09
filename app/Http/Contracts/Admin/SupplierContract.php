<?php

namespace App\Http\Contracts\Admin;

interface SupplierContract
{
  public function listAllSupplier(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

  public function createSupplier(array $attributes);

  public function updateSupplier(array $attributes);

  public function findSupplierById(int $id);

  public function deleteSupplier(int $id);

}
