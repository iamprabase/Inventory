<?php

namespace App\Http\Contracts\Admin;

interface StockTransferContract
{
  public function listAllStockTransfer(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

  public function listAllStockTransferWithSourceDestination(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

  public function listTopStockTransferWithSourceDestination(string $order = 'id', string $sort = 'desc', int $number = 5, array $columns = ['*']);

  public function createStockTransfer(array $attributes);

  public function updateStockTransfer(array $attributes);

  public function findStockTransferById(int $id);

  public function findStockTransferWithStockTransferDetailById(int $id);

  public function deleteStockTransfer(int $id);

}
