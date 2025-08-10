<?php

namespace App\View\Components;

use App\Models\Costumer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Stats extends Component
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

        // Filter transaksi hari ini
        $transactionsToday = Transaction::where('status', 'complete')
            ->whereDate('created_at', today())
            ->get();

        $costumers = Costumer::count();

        // Total modal: stock saat ini * harga modal
        $this->modal = $products->sum(function ($item) {
            return $item->stock * $item->cost_price;
        });

        // Total omset HARI INI
        $this->omset = $transactionsToday->sum('total');

        // Hitung profit HARI INI
        $transactionItemsToday = TransactionItem::with('product')
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'complete')
                      ->whereDate('created_at', today());
            })->get();

        $this->profit = $transactionItemsToday->sum(function ($item) {
            $cost = $item->product->cost_price ?? 0;
            $sell = $item->product->selling_price ?? 0;
            return ($sell - $cost) * $item->quantity;
        });

        $this->costumer = $costumers;

        // Jumlah barang terjual hari ini
        $this->terjual = $transactionItemsToday->sum('quantity');

        $this->jumlahProduct = $products->count();
    }

    public function render(): View|Closure|string
    {
        return view('components.stats');
    }
}
