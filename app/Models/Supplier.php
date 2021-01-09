<?php

namespace App\Models;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
  protected $guarded = [];
    
  public function setNameAttribute($value){
    $this->attributes['name'] = ucfirst($value);
  }

  public function setContactNameAttribute($value){
    $this->attributes['contact_person'] = ucfirst($value);
  }

}
