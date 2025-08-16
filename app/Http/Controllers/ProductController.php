<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $branchId = $request->input('branch_id');
        $products = Product::with([
            'category',
            'branches' => function ($q) use ($branchId) {
                if ($branchId) {
                    $q->where('branches.id', $branchId);
                }
            }
        ])
            ->when($branchId, function ($query) use ($branchId) {
                $query->whereHas('branches', function ($q) use ($branchId) {
                    $q->where('branches.id', $branchId);
                });
            })
            ->get();

        $branches = Branch::all();

        return view('pages.product.index', compact('products', 'branches', 'branchId'));
    }


    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
        $branches = Branch::all();
        return view('pages.product.create', compact('categories', 'branches'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:255',
            'sku'           => 'required|string|max:100|unique:products,sku',
            'branches'      => 'required|array',
            'branches.*.branch_id'      => 'required|exists:branches,id',
            'branches.*.initial_stock'  => 'required|numeric|min:0',
            'branches.*.cost_price'     => 'required|numeric|min:0',
            'branches.*.selling_price'  => 'required|numeric|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $productData = [
                'category_id' => $validated['category_id'],
                'name'        => $validated['name'],
                'sku'         => $validated['sku'],
            ];

            if ($request->hasFile('image')) {
                $productData['image'] = $request->file('image')->store('products', 'public');
            }

            $product = Product::create($productData);

            $pivotData = [];
            foreach ($validated['branches'] as $branch) {
                $pivotData[$branch['branch_id']] = [
                    'initial_stock' => $branch['initial_stock'],
                    'stock'         => $branch['initial_stock'],
                    'cost_price'    => $branch['cost_price'],
                    'selling_price' => $branch['selling_price'],
                ];
            }

            $product->branches()->sync($pivotData);

            DB::commit();

            return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error create product', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load('category','branches');
        return view('pages.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $branches = Branch::all();
        return view('pages.product.edit', compact('product', 'categories', 'branches'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:255',
            'sku'           => 'required|string|max:100',
            'branches'      => 'required|array',
            'branches.*.branch_id'      => 'required|exists:branches,id',
            'branches.*.initial_stock'  => 'required|numeric|min:0',
            'branches.*.cost_price'     => 'required|numeric|min:0',
            'branches.*.selling_price'  => 'required|numeric|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);


        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        try {
            DB::beginTransaction();

            $productData = [
                'category_id' => $validated['category_id'],
                'name'        => $validated['name'],
                'sku'         => $validated['sku'],
                'image'       => $request->hasFile('image') ?  $validated['image'] : $product->image
            ];


            $product->update($productData);

            $pivotData = [];
            foreach ($validated['branches'] as $branch) {
                $pivotData[$branch['branch_id']] = [
                    'initial_stock' => $branch['initial_stock'],
                    'stock'         => $branch['initial_stock'],
                    'cost_price'    => $branch['cost_price'],
                    'selling_price' => $branch['selling_price'],
                ];
            }

            $product->branches()->sync($pivotData);

            DB::commit();

            return redirect()->route('product.index')->with('success', 'Produk berhasil Di Perbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error create product', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            // Hapus relasi pivot
            $product->branches()->detach();

            // Hapus gambar jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Hapus produk
            $product->delete();

            DB::commit();

            return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error delete product', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}
