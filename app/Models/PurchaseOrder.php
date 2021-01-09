<?php

namespace App\Models;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
  protected $guarded = [];

  public function supplier()
  {
      return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
  }

  public function purchaseOrderDetails()
  {
      return $this->hasMany(PurchaseOrderDetail::class, 'purchase_order_id', 'id');
  }

}
