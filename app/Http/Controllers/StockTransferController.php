<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransfer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mutasi = StockTransfer::with('fromBranch', 'toBranch')->get();
        return view('pages.mutasi.index', compact('mutasi'));
    }

    public function getProductsByBranch(Request $request)
    {
        try {
            $branchId = $request->get('branch_id');

            if (!$branchId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Branch ID is required'
                ], 400);
            }

            // Get categories with products that have stock in selected branch
            $categories = Category::with(['products' => function ($query) use ($branchId) {
                $query->whereHas('branches', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId)
                        ->where('stock', '>', 0); // Only products with stock > 0
                })
                    ->with(['branches' => function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    }]);
            }])
                ->whereHas('products.branches', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId)
                        ->where('stock', '>', 0);
                })
                ->get();

            // Transform data untuk frontend
            $categoriesData = $categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'photo' => $category->photo,
                    'products' => $category->products->map(function ($product) {
                        $pivot = $product->branches->first();
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'image' => $product->image,
                            'pivot' => $pivot ? [
                                'stock' => $pivot->pivot->stock,
                                'cost_price' => $pivot->pivot->cost_price,
                            ] : null
                        ];
                    })
                ];
            })->filter(function ($category) {
                return $category['products']->isNotEmpty();
            })->values();

            return response()->json([
                'success' => true,
                'categories' => $categoriesData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading products: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        $categories = Category::all();
        return view('pages.mutasi.create', compact('branches', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required',
            'from_branch_id' => 'required',
            'to_branch_id' => 'required',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|min:1',
            'products.*.price' => 'required|min:0',
            'description' => 'nullable'
        ]);

        $today = now()->format('Ymd'); // 20250814
        $lastTransfer = StockTransfer::whereDate('created_at', now())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastTransfer) {
            // Ambil nomor urut terakhir lalu tambah 1
            $lastNumber = (int) substr($lastTransfer->reference, -3);
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }

        $reference = 'MT' . $today . '-' . $nextNumber;


        try {
            DB::beginTransaction();
            $mutasi = StockTransfer::create([
                'from_branch_id' => $validated['from_branch_id'],
                'to_branch_id' => $validated['to_branch_id'],
                'date' => $validated['date'],
                'notes' => $validated['description'],
                'reference' => $reference,
                'status' => 'complete'
            ]);

            $validated['products'] = collect($validated['products'])
                ->filter(fn($product) => (float) $product['quantity'] > 0)
                ->values()
                ->toArray();

            foreach ($validated['products'] as $key => $product) {
                $mutasi->transferItems()->create([
                    'product_id' => $product['product_id'],
                    'quantity' => (float)$product['quantity'],
                    'cost_price' => $product['price']
                ]);
                // update product stock branch
                $this->updateProduct($mutasi->from_branch_id, $mutasi->to_branch_id, $product['product_id'], $product['quantity']);
            }

            DB::commit();
            return redirect()->route('mutasi-stock.index')->with('success', "Berhasil Membuat Transaksi");
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('gagala transfer' . $e->getMessage());
            return back()->with('error', "Gagal Transfer Barang: " . $e->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(StockTransfer $stockTransfer, $id)
    {
        $stockTransfer = StockTransfer::with('transferItems')->find($id);
        return view('pages.mutasi.show', compact('stockTransfer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockTransfer $stockTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockTransfer $stockTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stockTransfer = StockTransfer::findOrFail($id);

        try {
            DB::beginTransaction();

            foreach ($stockTransfer->transferItems as $key => $transfer) {
                // Kembalikan stok
                $this->revertProductStock(
                    $stockTransfer->from_branch_id,
                    $stockTransfer->to_branch_id,
                    $transfer->product_id,
                    $transfer->quantity
                );
            }
            // Hapus mutasi
            $stockTransfer->delete();

            DB::commit();
            return back()->with('success', 'Mutasi berhasil dihapus dan stok dikembalikan.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error hapus mutasi: ' . $e->getMessage());
            return back()->with('error', 'Gagal Hapus Mutasi');
        }
    }

    protected function revertProductStock($fromBranch, $toBranch, $productId, $quantity)
    {
        // Tambah stok kembali di cabang asal
        DB::table('branch_products')
            ->where('branch_id', $fromBranch)
            ->where('product_id', $productId)
            ->increment('stock', $quantity);

        // Kurangi stok di cabang tujuan
        DB::table('branch_products')
            ->where('branch_id', $toBranch)
            ->where('product_id', $productId)
            ->decrement('stock', $quantity);
    }


    protected function updateProduct($fromBranch, $toBranch, $productId, $quantity)
    {
        // Kurangi stok di cabang asal
        DB::table('branch_products')
            ->where('branch_id', $fromBranch)
            ->where('product_id', $productId)
            ->decrement('stock', $quantity);

        // Tambah stok di cabang tujuan
        $exists = DB::table('branch_products')
            ->where('branch_id', $toBranch)
            ->where('product_id', $productId)
            ->exists();

        if ($exists) {
            DB::table('branch_products')
                ->where('branch_id', $toBranch)
                ->where('product_id', $productId)
                ->increment('stock', $quantity);
        } else {
            // Kalau produk belum ada di cabang tujuan
            DB::table('branch_products')->insert([
                'branch_id' => $toBranch,
                'product_id' => $productId,
                'initial_stock' => $quantity,
                'stock' => $quantity,
                'cost_price' => 0, // bisa diisi HPP
                'selling_price' => 0, // optional
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
