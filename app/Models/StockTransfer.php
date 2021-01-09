<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
  protected $guarded = [];

  public function source()
  {
      return $this->belongsTo(Location::class, 'source_location_id', 'id');
  }

  public function destination()
  {
      return $this->belongsTo(Location::class, 'destination_location_id', 'id');
  }

  public function stockTransferDetails()
  {
      return $this->hasMany(StockTransferDetail::class, 'stock_transfer_id', 'id');
  }

}
