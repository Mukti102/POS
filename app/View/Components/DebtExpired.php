<?php

namespace App\View\Components;

use App\Models\Debt;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DebtExpired extends Component
{
    /**
     * Create a new component instance.
     */
    public $todayDebt;
    public function __construct()
    {

        $now = now()->format('D F Y');
        $todayDebt = Debt::with('transaction.costumer')->get()->filter(function ($debt) {
            return $debt->due_date == now()->toDateString();
        });

        $this->todayDebt = $todayDebt;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.debt-expired');
    }
}
