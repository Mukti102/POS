<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\DebtPayment;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtPaymentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'debt_id'      => 'required|exists:debts,id',
            'amount'       => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'notes'        => 'nullable|string'
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Simpan pembayaran
                $payment = DebtPayment::create($validated);

                // Update data hutang
                $this->updateDebt($validated['debt_id'], $validated['amount']);
            });

            return back()->with('success', 'Berhasil Bayar Tagihan');
        } catch (Exception $e) {
            return back()->withErrors('Gagal Bayar Tagihan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, DebtPayment $debtPayment,$id)
    {   
        $debtPayment = DebtPayment::find($id);
        $validated = $request->validate([
            'debt_id'      => 'required|exists:debts,id',
            'amount'       => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'notes'        => 'nullable|string'
        ]);
        
        try {
            DB::transaction(function () use ($debtPayment, $validated) {
                $oldAmount = $debtPayment->amount;
                

                // Update pembayaran
                $debtPayment->update($validated);

                // Hitung selisih pembayaran
                $difference = $validated['amount'] - $oldAmount;
                // Update data hutang dengan selisih
                $this->updateDebt($validated['debt_id'], $validated['amount'],'update',$oldAmount);
            });

            return back()->with('success', 'Berhasil Update Bayar Tagihan');
        } catch (Exception $e) {
            return back()->withErrors('Gagal Update Bayar Tagihan: ' . $e->getMessage());
        }
    }

    public function destroy(DebtPayment $debtPayment,$id)
    {   
        $debtPayment = DebtPayment::find($id);
        try {
            DB::transaction(function () use ($debtPayment) {
                $amount = $debtPayment->amount;
                $debtId = $debtPayment->debt_id;

                // Hapus pembayaran
                $debtPayment->delete();

                // Kurangi pembayaran di hutang
                $this->updateDebt($debtId, -$amount);
            });

            return back()->with('success', 'Berhasil Hapus Pembayaran');
        } catch (Exception $e) {
            return back()->withErrors('Gagal Hapus Pembayaran: ' . $e->getMessage());
        }
    }

    protected function updateDebt($debt_id, $amountChange,$status='store',$oldAmount=null)
    {
        $debt = Debt::findOrFail($debt_id);

        if($status == 'store'){
            // Update nilai paid & remaining
            $debt->paid += $amountChange;
            // Pastikan remaining minimal 0
            $debt->remaining = (float) $debt->total_debt - (float) $debt->paid;
        }else{
            $debt->paid = $debt->paid - $oldAmount;
            $debt->paid += $amountChange;
            $debt->remaining = (float) $debt->total_debt - (float) $debt->paid;
        }

        // Jika sudah lunas
        if ($debt->total_debt <= $debt->paid) {
            $debt->status = 'lunas';

            $transaction = Transaction::find($debt->transaction_id);
            $transaction->status = 'complete';
            $transaction->status_payment = 'paid';
            $transaction->save();
        } else {

            $debt->status = 'belum lunas';

            $transaction = Transaction::find($debt->transaction_id);
            $transaction->paid += $amountChange;
            $transaction->status = 'pending';
            $transaction->status_payment = 'due';
            $transaction->save();
        }
        $debt->save();
    }
}
