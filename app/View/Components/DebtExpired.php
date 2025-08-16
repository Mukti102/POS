<?php

namespace App\View\Components;

use App\Models\Debt;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class DebtExpired extends Component
{
    /**
     * Create a new component instance.
     */
    public $todayDebt;

    public function __construct()
    {
        $branchId = request()->get('branch_id') ?? Auth::user()->branch_id;

        $this->todayDebt = Debt::with('transaction.costumer')
            ->whereHas('transaction', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })
            ->whereDate('due_date', now()) // langsung cek due_date di query
            ->get();
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.debt-expired');
    }
}
