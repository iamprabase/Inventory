<?php

namespace App\Http\Contracts\Admin;

interface CategoryContract
{
    public function listAllCategory(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    public function createCategory(array $attributes);
  
    public function updateCategory(array $attributes);
  
    public function findCategoryById(int $id);

    public function deleteCategory(int $id);
}
