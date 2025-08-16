<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Purchase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {   
        $branchid = Branch::first()->id;
        $branchId = $request->input('branch_id') ?? $branchid;

        $purchases = Purchase::with(['product', 'branch'])
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })
            ->latest()
            ->get();

        $products = Product::with('category', 'branches')->get();
        $branches = Branch::all();

        return view('pages.purchase.index', compact('purchases', 'products', 'branches', 'branchId'));
    }


    public function create()
    {
        $products = Product::all();
        return view('pages.purchase.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id'   => 'required|exists:branches,id',
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|numeric|min:1',
            'cost_price'  => 'required|numeric|min:0'
        ], [
            'required' => 'Harus diisi',
            'numeric'  => 'Harus berupa angka',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Simpan pembelian
                $purchase = Purchase::create($validated);

                // Update stok & harga beli di pivot
                $this->updateProduct(
                    $validated['branch_id'],
                    $validated['product_id'],
                    $validated['quantity'],
                    $validated['cost_price']
                );
            });

            return redirect()->route('pengadaan.index')->with('success', "Berhasil ditambahkan");
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menambahkan pembelian: ' . $e->getMessage())->withInput();
        }
    }


    public function edit(Purchase $purchase)
    {
        $products = Product::all();
        $branches = Branch::all();
        return view('pages.purchase.edit', compact('purchase', 'products', 'branches'));
    }
    public function update(Request $request, Purchase $purchase,$id)
    {   
        $purchase = Purchase::find($id);
        $validated = $request->validate([
            'branch_id'   => 'required|exists:branches,id',
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|numeric|min:1',
            'cost_price'  => 'required|numeric|min:0'
        ]);


        try {
            DB::transaction(function () use ($validated, $purchase) {
                $oldBranchId  = $purchase->branch_id;
                $oldProductId = $purchase->product_id;
                $oldQuantity  = $purchase->quantity;

                
                // Update stok
                if ($oldBranchId == $validated['branch_id'] && $oldProductId == $validated['product_id']) {
                    // Cabang & produk sama → hitung selisih
                    $diff = $validated['quantity'] - $oldQuantity;
                    $this->updateProduct($validated['branch_id'], $validated['product_id'], $diff, $validated['cost_price']);
                } else {
                    // Kurangi stok dari pembelian lama
                    $this->updateProduct($oldBranchId, $oldProductId, -$oldQuantity);

                    // Tambahkan stok ke pembelian baru
                    $this->updateProduct($validated['branch_id'], $validated['product_id'], $validated['quantity'], $validated['cost_price']);
                }

                // Simpan perubahan purchase
                $purchase->update($validated);
            });

            return redirect()->route('pengadaan.index')->with('success', "Data pembelian berhasil diperbarui");
        } catch (Exception $e) {
            Log::info('update purchase ' . $e->getMessage());
            return back()->with('error', 'Gagal mengubah pembelian: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Purchase $purchase,$id)
    {   
        $purchase = Purchase::find($id);
        try {
            DB::transaction(function () use ($purchase) {
                // Kurangi stok sesuai pembelian yang dihapus
                $this->updateProduct($purchase->branch_id, $purchase->product_id, -$purchase->quantity);

                // Hapus purchase
                $purchase->delete();
            });

            return redirect()->route('pengadaan.index')->with('success', "Data pembelian berhasil dihapus");
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menghapus pembelian: ' . $e->getMessage());
        }
    }


    protected function updateProduct($branchId, $productId, $quantity, $costPrice = null)
    {
        $product = Product::findOrFail($productId);

        $pivot = $product->branches()->where('branch_id', $branchId)->first();

        if (!$pivot) {
            throw new \Exception("Produk belum terdaftar di cabang ini.");
        }

        $newStock = $pivot->pivot->stock + $quantity;

        if ($newStock < 0) {
            throw new \Exception("Stok tidak cukup untuk melakukan perubahan ini.");
        }

        $updateData = ['stock' => $newStock];
        if (!is_null($costPrice)) {
            $updateData['cost_price'] = $costPrice;
        }

        $product->branches()->updateExistingPivot($branchId, $updateData);
    }
}
