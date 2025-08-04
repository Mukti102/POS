<?php

namespace App\View\Components\transactionDetail;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class top extends Component
{
    /**
     * Create a new component instance.
     */
    public $transaction;
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components..transaction-detail.top');
    }
}
