<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('product')->latest()->get();
        $products = Product::with('category')->get();
        return view('pages.purchase.index', compact('purchases', 'products'));
    }

    public function create()
    {
        $products = Product::all();
        return view('pages.purchase.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'cost_price' => 'required|numeric|min:0'
        ], [
            'required' => 'Harus diisi',
            'numeric' => 'Harus berupa angka',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $purchase = Purchase::create($validated);
                $this->updateProduct($purchase->product_id, $purchase->quantity);
            });

            return redirect()->route('pengadaan.index')->with('success', "Berhasil ditambahkan");
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menambahkan pembelian: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Purchase $purchase)
    {
        $products = Product::all();
        return view('pages.purchase.edit', compact('purchase', 'products'));
    }

    public function update(Request $request, Purchase $purchase,$id)
    {       
        $purchase =  Purchase::find($id);
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'cost_price' => 'required|numeric|min:0'
        ]);

        try {
            DB::transaction(function () use ($validated, $purchase) {
                // Kurangi stok lama
                $this->updateProduct($purchase->product_id, -$purchase->quantity);

                // Update data
                $purchase->update($validated);

                // Tambahkan stok baru
                $this->updateProduct($purchase->product_id, $validated['quantity'], $validated['cost_price']);
            });

            return redirect()->route('pengadaan.index')->with('success', 'Data berhasil diperbarui.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memperbarui: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Purchase $purchase,$id)
    {   
        $purchase = Purchase::find($id);
        try {
            DB::transaction(function () use ($purchase) {
                // Kurangi stok dari pembelian yang dihapus
                $this->updateProduct($purchase->product_id, -$purchase->quantity);
                $purchase->delete();
            });

            return redirect()->route('pengadaan.index')->with('success', 'Data berhasil dihapus.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    protected function updateProduct($productId, $quantity, $costPrice = null)
    {
        $product = Product::findOrFail($productId);

        if (!$product) {
            throw new \Exception("Produk dengan ID $productId tidak ditemukan.");
        }

        // Update stok
        $product->stock += $quantity;

        $product->save();
    }
}
