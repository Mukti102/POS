<?php

namespace App\View\Components\pos;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class recentTransaction extends Component
{
    /**
     * Create a new component instance.
     */
    public $transactions;
    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pos.recent-transaction');
    }
}
