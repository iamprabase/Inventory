<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    protected $table = 'image_product';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
