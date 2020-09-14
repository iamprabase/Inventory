<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ImageProduct;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $guarded = [];
    
  public function setNameAttribute($value){
    $this->attributes['name'] = ucfirst($value);
  }

  public function brand()
  {
      return $this->belongsTo(Brand::class);
  }

  public function category()
  {
      return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
  }

  public function image()
  {
      return $this->hasMany(ImageProduct::class, 'product_id', 'id');
  }
}
