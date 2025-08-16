<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchProduct extends Model
{
    // Branch.php
    public function products()
    {
        return $this->belongsToMany(Product::class, 'branch_products')
            ->withPivot('initial_stock', 'stock', 'cost_price', 'selling_price')
            ->withTimestamps();
    }

    // Product.php
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_products')
            ->withPivot('initial_stock', 'stock', 'cost_price', 'selling_price')
            ->withTimestamps();
    }
}
