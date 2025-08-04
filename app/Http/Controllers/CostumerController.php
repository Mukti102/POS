<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use Exception;
use Illuminate\Http\Request;

class CostumerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $costumers = Costumer::all();
        return view('pages.costumer.index', compact('costumers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'address' => 'nullable'
        ], [
            'name.required' => 'Nama harus diisi.'
        ]);

        try {
            Costumer::create($validated);
            return back()->with('success', 'Berhasil ditambahkan.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal ditambahkan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Costumer $costumer)
    {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'address' => 'nullable'
        ], [
            'name.required' => 'Nama harus diisi.'
        ]);

        try {
            $costumer->update($validated);
            return back()->with('success', 'Berhasil diperbarui.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memperbarui: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Costumer $costumer)
    {
        try {
            $costumer->delete();
            return back()->with('success', 'Berhasil dihapus.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
