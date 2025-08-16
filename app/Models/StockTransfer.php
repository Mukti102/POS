<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    protected $guarded = ['id'];


    public function fromBranch(){
        return $this->belongsTo(Branch::class,'from_branch_id');
    }

    public function toBranch(){
        return $this->belongsTo(Branch::class,'to_branch_id');
    }

    public function transferItems(){
        return $this->hasMany(StockTransferItems::class,'stock_transfer_id');
    }
}
