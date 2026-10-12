<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kamar;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('kamar.blokAsrama')->paginate(15);
        return view('pengurus.users.index', compact('users'));
    }

    public function create()
    {
        $kamarList = Kamar::with('blokAsrama')->get();
        return view('pengurus.users.create', compact('kamarList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_identitas' => 'required|string|max:50|unique:users',
            'username' => 'required|string|max:100|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:penghuni,keamanan,pengurus',
            'kamar_id' => 'nullable|exists:kamar,id',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);

        return redirect()->route('pengurus.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $kamarList = Kamar::with('blokAsrama')->get();
        return view('pengurus.users.edit', compact('user', 'kamarList'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_identitas' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:penghuni,keamanan,pengurus',
            'kamar_id' => 'nullable|exists:kamar,id',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('pengurus.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        
        $user->delete();
        return redirect()->route('pengurus.users.index')->with('success', 'User berhasil dihapus.');
    }
}
