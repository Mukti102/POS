<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use App\Models\Debt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hutangs = Debt::with('transaction.costumer')->get();
        $costumers = Costumer::with('transactions.debt')->get();

        $debts = $costumers
            ->map(function ($item) {
                $debtTransactions = $item->transactions->where('status', '!=', 'complete');

                if ($debtTransactions->count() == 0) {
                    return null; // return null kalau tidak ada transaksi hutang
                }

                $total = $debtTransactions
                    ->map(fn($trx) => (float) ($trx->debt?->total_debt ?? 0))
                    ->sum();

                $paid = $debtTransactions
                    ->map(fn($trx) => (float) ($trx->debt?->paid ?? 0))
                    ->sum();

                $remaining = $debtTransactions
                    ->map(fn($trx) => (float) ($trx->debt?->remaining ?? 0))
                    ->sum();

                return [
                    'id'        => $item->id,
                    'costumer'  => $item->name,
                    'total'     => $total,
                    'paid'      => $paid,
                    'remaining' => $remaining,
                    'status'    => $paid >= $total ? 'lunas' : 'Belum Lunas'
                ];
            })
            ->filter() // buang data null
            ->values(); // reset index

        return view('pages.debt.index', compact('hutangs', 'debts'));
    }


    public function print()
    {
        $debts = Debt::with('transaction.costumer')->get();

        $pdf = Pdf::loadView('pages.debt.print', compact('debts'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('daftar-debt.pdf'); // tampilkan preview di browser
    }

    public function detail($id)
    {
        $costumer = Costumer::with('transactions')->find($id);
        $transactions = $costumer->transactions->where('status', '!=', 'complete');
        $debts = $transactions->pluck('debt');
        return view('pages.debt.detail', compact('debts', 'costumer'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Debt $debt)
    {
        $payments = $debt->payments;
        return view('pages.debt.payments', compact('payments', 'debt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Debt $debt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Debt $debt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debt $debt)
    {
        $debt->delete();
        return back()->with('success', 'Berhasil Di Hapus');
    }
}
