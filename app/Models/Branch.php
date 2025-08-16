<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'branch_products')
            ->withPivot('initial_stock', 'stock', 'cost_price', 'selling_price')
            ->withTimestamps();
    }
}
