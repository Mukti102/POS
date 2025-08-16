<?php

namespace App\View\Components;

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class ProductExpired extends Component
{
    public $products;
    public $branch;

    public function __construct()
    {   
        $branchId = request()->get('branch_id') ?? Auth::user()->branch_id;

        $branch = Branch::with(['products' => function($query) {
            $query->wherePivot('stock', '<', 5); // stok kurang dari 5
        }])->find($branchId);

        $this->products = $branch ? $branch->products : collect();
        $this->branch = $branch;
    }

    public function render()
    {
        return view('components.product-expired');
    }
}
