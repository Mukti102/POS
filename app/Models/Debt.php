<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $guarded = ['id'];

    public function transaction(){
        return $this->belongsTo(Transaction::class,'transaction_id');
    }
}
