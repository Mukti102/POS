<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];
    
    public function costumer(){
        return $this->belongsTo(Costumer::class,'costumer_id');
    }

    public function transactionItems(){
        return $this->hasMany(TransactionItem::class);
    }

    public function debt(){
        return $this->hasOne(Debt::class,'transaction_id');
    }
}
