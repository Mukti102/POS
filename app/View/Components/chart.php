<?php

namespace App\View\Components;

use App\Models\Transaction;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class chart extends Component
{
    /**
     * Create a new component instance.
     */
    public $revenueData = [];
    public $profitData = [];

    public function __construct()
    {
        $transactions = Transaction::where('status', 'complete')->get();

        // Ambil semua transaksi lengkap berdasarkan bulan
        $monthlyData = Transaction::select(
            DB::raw('MONTH(transaction_date) as month'),
            DB::raw('SUM(total) as revenue'),
            DB::raw('SUM(total - (SELECT SUM(products.cost_price * transaction_items.quantity) 
                    FROM transaction_items 
                    JOIN products ON products.id = transaction_items.product_id 
                    WHERE transaction_items.transaction_id = transactions.id)) as profit')
        )
            ->where('status', 'complete')
            ->groupBy(DB::raw('MONTH(transaction_date)'))
            ->get();


        $revenue = [];
        $profit = [];

        // Buat array 12 bulan default
        for ($i = 1; $i <= 12; $i++) {
            $revenue[$i] = 0;
            $profit[$i] = 0;
        }

        foreach ($monthlyData as $data) {
            $revenue[$data->month] = (int) $data->revenue;
            $profit[$data->month] = (int) $data->profit;
        }

        // Simpan ke properti untuk dikirim ke Blade
        $this->revenueData = array_values($revenue);
        $this->profitData = array_values($profit);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chart');
    }
}
