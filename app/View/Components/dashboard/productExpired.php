<?php

namespace App\View\Components\Dashboard;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductExpired extends Component
{
    /**
     * Create a new component instance.
     */
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

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.product-expired');
    }
}
