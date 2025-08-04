<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Costumer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\json;
use function PHPSTORM_META\map;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('costumer')->get();
        return view('pages.transaction.index', compact('transactions'));
    }

    public function pos()
    {
        $categories = Category::with('products')->get();
        $costumers = Costumer::all();
        $products = Product::with('category')->get();
        $transactions = Transaction::with('costumer')->where('transaction_date', now()->format('Y-m-d'))->get();
        return view('pages.transaction.pos', compact('categories', 'costumers', 'products', 'transactions'));
    }



    public function create()
    {
        $costumers = Costumer::all();
        $products = Product::with('category')->get();
        return view('pages.transaction.create', compact('costumers', 'products'));
    }

    public function checkout(Request $request)
    {
        $jsonCart = $request->cart_data;
        $cart = json_decode($jsonCart);

        $reference = 'TRX-' . strtoupper(Str::random(6)) . '-' . now()->format('YmdHis');

        try {
            DB::beginTransaction();

            // Buat transaksi utama
            $transaction = Transaction::create([
                'costumer_id' => $request->customer_id,
                'total' => $request->total,
                'paid' => $request->paid,
                'change' => $request->change,
                'reference' => $reference,
                'status_payment' => $request->paid >= $request->total ? 'paid' : 'due',
                'status' => $request->paid >= $request->total ? 'complete' : 'pending',
                'transaction_date' => now()->format('Y-m-d'),
            ]);

            // Simpan item transaksi
            foreach ($cart as $prod) {
                $transaction->transactionItems()->create([
                    'product_id' => $prod->id,
                    'quantity' => $prod->quantity,
                    'subtotal' => $prod->price * $prod->quantity,
                ]);

                $this->updateProduct($prod->id, -$prod->quantity);
            }

            DB::commit();
            return back()->with('success', "Berhasil Membuat Transaksi");
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', "Gagal Membuat Transaksi: " . $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'costumer_id' => 'required|exists:costumers,id',
            'transaction_date' => 'nullable|date',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'subtotal' => 'required|numeric|min:0',
            'paid' => 'required|numeric|min:0',
            'change' => 'required|numeric',
            'status_payment' => 'required|in:paid,due',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);
            $subtotal = $product->selling_price * $request->quantity;

            $reference = 'TRX-' . strtoupper(Str::random(6)) . '-' . now()->format('YmdHis');

            $transaction = Transaction::create([
                'costumer_id' => $request->costumer_id,
                'total' => $subtotal,
                'paid' => $request->paid,
                'change' => $request->paid - $subtotal,
                'reference' => $reference,
                'status_payment' => $request->status_payment,
                'status' => $request->status_payment === 'paid' ? 'complete' : 'pending',
                'transaction_date' => $request->transaction_date ?? now()->toDateString(),
            ]);

            if ($transaction->status !== 'complete') {
                $this->createDebt($transaction);
            }

            $transaction->transactionItems()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'subtotal' => $subtotal,
            ]);



            $this->updateProduct($request->product_id, -$request->quantity); // kurangi stok

            DB::commit();
            return redirect()->route('transaction.index')->with('success', 'Transaksi berhasil disimpan.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('costumer', 'transactionItems.product');
        return view('pages.transaction.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $costumers = Costumer::all();
        $products = Product::all();
        $transaction->load('transactionItems');
        return view('pages.transaction.edit', compact('transaction', 'costumers', 'products'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'costumer_id' => 'required|exists:costumers,id',
            'transaction_date' => 'nullable|date',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'subtotal' => 'required|numeric|min:0',
            'paid' => 'required|numeric|min:0',
            'change' => 'required|numeric',
            'status_payment' => 'required|in:paid,due',
        ]);

        try {
            DB::beginTransaction();

            $oldItem = $transaction->transactionItems()->first();
            $this->updateProduct($oldItem->product_id, $oldItem->quantity); // rollback stok lama

            $product = Product::findOrFail($request->product_id);
            $subtotal = $product->selling_price * $request->quantity;

            $transaction->update([
                'costumer_id' => $request->costumer_id,
                'total' => $subtotal,
                'paid' => $request->paid,
                'change' => $request->paid - $subtotal,
                'status_payment' => $request->status_payment,
                'status' => $request->status_payment === 'paid' ? 'complete' : 'pending',
                'transaction_date' => $request->transaction_date ?? now()->toDateString(),
            ]);

            if ($transaction->status !== 'complete') {
                if ($transaction->debt) {
                    $this->updateDebt($transaction);
                } else {
                    $this->createDebt($transaction);
                }
            } elseif ($transaction->debt) {
                $transaction->debt->delete(); // hapus debt jika sudah lunas
            }


            $oldItem->update([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'subtotal' => $subtotal,
            ]);

            $this->updateProduct($request->product_id, -$request->quantity); // kurangi stok baru

            DB::commit();
            return redirect()->route('transaction.index')->with('success', 'Transaksi berhasil diubah.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengubah transaksi: ' . $e->getMessage());
        }
    }

    public function destroy(Transaction $transaction)
    {
        try {
            DB::beginTransaction();

            foreach ($transaction->transactionItems as $item) {
                $this->updateProduct($item->product_id, $item->quantity); // kembalikan stok
            }

            $transaction->transactionItems()->delete();
            $transaction->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    protected function updateProduct($productId, $quantityChange)
    {
        $product = Product::findOrFail($productId);

        $newStock = $product->stock + $quantityChange;

        if ($newStock < 0) {
            throw new \Exception("Stok produk tidak mencukupi.");
        }

        $product->stock = $newStock;
        $product->save();
    }


    protected  function createDebt($transaction, $status = 'belum lunas')
    {
        try {
            $transaction->debt()->create([
                'total_debt' => $transaction->total,
                'paid' => $transaction->paid,
                'remaining' => $transaction->total - $transaction->paid,
                'due_date' => now()->addMonth(), //default sebulan dari sekarang ,
                'status' =>  $status
            ]);
        } catch (Exception $e) {
            throw new \Exception('Gagal Buat Debt');
        }
    }

    protected function updateDebt($transaction)
    {
        try {
            if (!$transaction->debt) return;

            $transaction->debt->update([
                'total_debt' => $transaction->total,
                'paid' => $transaction->paid,
                'remaining' => $transaction->total - $transaction->paid,
                'status' => $transaction->paid >= $transaction->total ? 'lunas' : 'belum lunas',
                'due_date' => now()->addMonth(), // kamu bisa buat optional kalau due_date tidak ingin berubah
            ]);
        } catch (Exception $e) {
            throw new \Exception('Gagal Update Debt');
        }
    }
}
