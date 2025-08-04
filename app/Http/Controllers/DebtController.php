<?php

namespace App\Http\Controllers;

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
        return view('pages.debt.index', compact('hutangs'));
    }

    public function print()
    {
        $debts = Debt::with('transaction.costumer')->get();

        $pdf = Pdf::loadView('pages.debt.print', compact('debts'))
         ->setPaper('a4', 'landscape');

        return $pdf->stream('daftar-debt.pdf'); // tampilkan preview di browser
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
        //
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
