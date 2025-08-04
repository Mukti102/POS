<?php

namespace App\View\Components\dashboard;

use App\Models\Costumer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardStats extends Component
{
    public $modal;
    public $omset;
    public $profit;
    public $costumer;
    public $terjual;
    public $jumlahProduct;

    public function __construct()
    {
        $products = Product::all();
        $transactions = Transaction::where('status', 'complete')->get();
        $costumers = Costumer::count();
        // Total modal: stock saat ini * harga modal
        $this->modal = $products->sum(function ($item) {
            return $item->stock * $item->cost_price;
        });

        // Total omset (penjualan)
        $this->omset = $transactions->sum('total');

        // Hitung profit (penjualan - modal produk yang terjual)
        $transactionItems = TransactionItem::with('product')
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'complete');
            })->get();

        $this->profit = $transactionItems->sum(function ($item) {
            $cost = $item->product->cost_price ?? 0;
            $sell = $item->product->selling_price ?? 0;
            return ($sell - $cost) * $item->quantity;
        });

        $this->costumer = $costumers;

        $this->terjual = $transactionItems->sum('quantity');

        $this->jumlahProduct = $products->count();
    }

    public function render(): View|Closure|string
    {
        return view('components.dashboard.card-stats');
    }
}
