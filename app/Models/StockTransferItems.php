<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransferItems extends Model
{
    protected $guarded = ['id'];

    public function mutasi() {
        return $this->belongsTo(StockTransfer::class,'stock_transfer_id');
    }
}
