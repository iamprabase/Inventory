<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = [];
    
    public function setNameAttribute($value){
      $this->attributes['name'] = ucfirst($value);
    }
}
