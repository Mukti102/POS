<?php

namespace App\View\Components\Dashboard;

use App\Models\Branch;
use App\Models\Costumer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\Component;

class Stats extends Component
{
    /**
     * Create a new component instance.
     */
    public $modal;
    public $omset;
    public $profit;
    public $costumer;
    public $terjual;
    public $jumlahProduct;

    public function __construct()
    {
        // Ambil branch_id dari query atau dari user login
        $branchId = request()->get('branch_id') ?? Auth::user()->branch_id;

        // Ambil branch untuk relasi produk
        $branch = Branch::find($branchId);

        // Produk pada branch ini
        $products = Product::with([
            'branches' => function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            }
        ])->get();

        // Filter transaksi hari ini berdasarkan branch
        $transactionsToday = Transaction::where('status', 'complete')
            ->where('branch_id', $branchId)
            ->whereDate('created_at', today())
            ->get();

        // Hitung total costumer di branch ini
        $costumers = Costumer::count();

        if ($branch) {
            // Total modal: stock saat ini * harga modal (pakai relasi products di branch)
            $this->modal = $branch->products->sum(function ($product) {
                // dd((float)$product->pivot->stock , (float)$product->pivot->cost_price,(float)$product->pivot->stock * (float)$product->pivot->cost_price);
                return $product->pivot->stock * $product->pivot->cost_price;
            });
        }

        // Total omset hari ini
        $this->omset = $transactionsToday->sum('total');

        // Hitung profit hari ini
        $transactionItemsToday = TransactionItem::with('product')
            ->whereHas('transaction', function ($query) use ($branchId) {
                $query
                    ->where('branch_id', $branchId)
                    ->whereDate('created_at', today());
            })->get();

        $this->profit = $transactionItemsToday->sum(function ($item) use ($branchId) {
            // Cari branch yang sesuai
            $branchPivot = $item->product->branches
                ->where('id', $branchId) // id di sini adalah id branch
                ->first();

            $cost = $branchPivot?->pivot->cost_price ?? 0;
            $sell = $branchPivot?->pivot->selling_price ?? 0;

            return ($sell - $cost) * $item->quantity;
        });


        // Jumlah costumer di branch ini
        $this->costumer = $costumers;

        // Jumlah barang terjual hari ini
        $this->terjual = $transactionItemsToday->sum('quantity');

        // Jumlah total produk di branch ini
        $this->jumlahProduct = $products->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.stats');
    }
}
