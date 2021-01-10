<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $guarded = [];
    
  public function setNameAttribute($value){
    $this->attributes['name'] = ucfirst($value);
  }

  public function products()
  {
      return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
  }
}
