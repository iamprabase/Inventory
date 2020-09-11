<?php
namespace App\Http\Repositories;

use App\Http\Contracts\BaseContract;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseContract{

  protected $model;

  public function __construct(Model $model){
    $this->model = $model;
  }

  public function all(string $orderBy = 'id', string $sort = 'desc', array $columns = ['*']){
    return $this->model->orderBy($orderBy, $sort)->get($columns);
  }

  // public function create(array $attributes){
  //   return $this->model->create($attributes);
  // }

  // public function update(array $attributes, $id){
  //   return $this->model->find($id)->update($attributes);
  // }

  public function find(int $id){
    return $this->model->find($id);
  }

  public function findOrFail(int $id){
    return $this->model->findOrFail($id);
  }

  public function findBy(array $searchParams){
    return $this->model->where($searchParams)->all();
  }

  public function findOneBy(array $searchParam){
    return $this->model->where($searchParams)->first();
  }

  public function findOrFailOneBy(array $searchParam){
    return $this->model->where($searchParams)->firstOrFail();
  }

  public function delete($id){
    return $this->model->find($id)->delete();
  }
}