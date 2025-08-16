<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_products','product_id','branch_id',)
            ->withPivot('initial_stock', 'stock', 'cost_price', 'selling_price')
            ->withTimestamps();
    }
}
