<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('branch')->get();
        $branches = Branch::all();
        return view('pages.user.index', compact('users', 'branches'));
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
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => 'required',
            'phone' => 'required',
            'address' => 'nullable',
            'role' => 'required',
            'branch_id' => 'required',
        ]);

        try {
            $validated['password'] = Hash::make($validated['password']);
            $validated['avatar'] = 'tidak ada';
            User::create($validated);
            return back()->with('success', 'Berhasil Menambahkan User');
        } catch (Exception $e) {
            Log::info('user create', ['message' => 'gagal menambahkan user' . $e->getMessage()]);
            return back()->with('error', 'Gagal Membuat User');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'phone' => 'required',
            'role' => 'required',
            'address' => 'nullable',
            'branch_id' => 'required',
        ]);


        try {
            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']); // biar password lama tidak terubah
            }

            $user->update($validated);

            return back()->with('success', 'Berhasil mengupdate user');
        } catch (Exception $e) {
            Log::error('user update', ['message' => 'gagal update user: ' . $e->getMessage()]);
            return back()->with('error', 'Gagal mengupdate user');
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return back()->with('success', 'Berhasil menghapus user');
        } catch (Exception $e) {
            Log::error('user delete', ['message' => 'gagal menghapus user: ' . $e->getMessage()]);
            return back()->with('error', 'Gagal menghapus user');
        }
    }
}
