<?php

namespace App\Http\Contracts;

interface BaseContract{

  public function all(string $orderBy = 'id', string $sort = 'desc', array $columns = ['*']);
  
  // public function create(array $attributes);

  // public function update(array $attributes, $id);

  public function find(int $id);

  public function findOrFail(int $id);

  public function findBy(array $searchParams);

  public function findOneBy(array $searchParam);

  public function findOrFailOneBy(array $searchParam);

  public function delete($id);

}