<?php

namespace App\View\Components\Dashboard;


use App\Models\Branch;
use Carbon\Carbon;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Chart extends Component
{
    /**
     * Create a new component instance.
     */
     public $revenueData = [];
    public $profitData = [];
    public $branches;

    public function __construct()
    {
        $this->branches = Branch::all();

        $branchId = request()->get('branch_id') ?? Auth::user()->branch_id;

        // Ambil semua transaksi selesai di branch ini + relasi produk & branch (pivot)
        $transactions = Transaction::where('status', 'complete')
            ->where('branch_id', $branchId)
            ->with(['transactionItems.product.branches' => function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            }])
            ->get();

        // Default bulan Jan - Dec
        $months = range(1, 12);
        $revenue = array_fill_keys($months, 0);
        $profit = array_fill_keys($months, 0);

        foreach ($transactions as $transaction) {
            $month = (int) Carbon::parse($transaction->transaction_date)->format('n');

            // Tambah revenue (omzet)
            $revenue[$month] += $transaction->total;

            // Hitung profit: total - (modal * qty)
            foreach ($transaction->transactionItems as $item) {
                $branchProduct = $item->product->branches->first(); // branch yg sesuai sudah difilter di with()
                $costPrice = $branchProduct?->pivot?->cost_price ?? 0;
                $profit[$month] += ($item->price - $costPrice) * $item->quantity;
            }
        }

        // Simpan ke public property untuk Blade
        $this->revenueData = array_values($revenue);
        $this->profitData = array_values($profit);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.chart');
    }
}
