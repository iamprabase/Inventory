<?php

namespace App\Http\Repositories\Admin;

use App\Models\Category;
use Illuminate\Database\QueryException;
use App\Http\Repositories\BaseRepository;
use App\Http\Contracts\Admin\CategoryContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryRepository extends BaseRepository implements CategoryContract
{
  public function __construct(Category $model)
  {
      parent::__construct($model);
      $this->model = $model;
  }

  public function listAllCategory(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
  {
      return $this->all($order, $sort, $columns);
  }

  public function createCategory(array $attributes)
  {
      try {
          $collection = collect($attributes);

          $brand = new Category($collection->all());

          $brand->save();

          return $brand;
      } catch (QueryException $e) {
          throw new QueryException($e->getMessage());
      }
  }

  public function updateCategory(array $attributes)
  {
      $brand = $this->findCategoryById($attributes['id']);
      $collection = collect($attributes)->except('_token');

      $brand->update($collection->all());

      return $brand;
  }

  public function findCategoryById(int $id)
  {
      try {
          return $this->findOrFail($id);
      } catch (ModelNotFoundException $e) {
          throw new ModelNotFoundException($e);
      }
  }

  public function deleteCategory(int $id)
  {
      $brand = $this->findCategoryById($id);

      $brand->delete();
  }
}
