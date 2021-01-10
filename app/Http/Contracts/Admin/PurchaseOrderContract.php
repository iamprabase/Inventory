<?php

namespace App\Http\Contracts\Admin;

interface PurchaseOrderContract
{
  public function listAllPurchaseOrder(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

  public function listAllPurchaseOrderWithSupplier(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

  public function listTopPurchaseOrderWithSupplier(string $order = 'id', string $sort = 'desc', int $number = 5,array $columns = ['*']);

  public function createPurchaseOrder(array $attributes);

  public function updatePurchaseOrder(array $attributes);

  public function findPurchaseOrderById(int $id);

  public function findPurchaseOrderWithPurchaseDetailById(int $id);

  public function deletePurchaseOrder(int $id);

}
