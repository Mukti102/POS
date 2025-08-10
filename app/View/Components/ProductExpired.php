<?php

namespace App\View\Components;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductExpired extends Component
{
    /**
     * Create a new component instance.
     */
    public $products;
    public function __construct()
    {
        $products = Product::with('category')->get()->filter(function ($product) {
            return $product->stock <= 5;
        });

        $this->products = $products;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-expired');
    }
}
