<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Exception;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::all();
        return view('pages.cabang.index', compact('branches'));
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
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);

        try {
            Branch::create($validated);
            return back()->with('success', 'Berhasil Menambahkan Cabang');
        } catch (Exception $e) {
            return back()->withErrors('Gagak membuat Cabang', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch,$id)
    {   
        $branch = Branch::find($id);
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);

        try {
            $branch->update($validated);
            return redirect()->back()->with('success', 'Cabang berhasil diperbarui');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui Cabang: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch,$id)
    {   
        $branch = Branch::find($id);
        try {
            $branch->delete();
            return redirect()->back()->with('success', 'Cabang berhasil dihapus');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus Cabang: ' . $e->getMessage()]);
        }
    }
}
