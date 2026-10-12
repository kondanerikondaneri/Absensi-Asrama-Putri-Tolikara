<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\BlokAsrama;

class KamarController extends Controller
{
    public function index()
    {
        $kamar = Kamar::with('blokAsrama')->paginate(15);
        return view('pengurus.kamar.index', compact('kamar'));
    }

    public function create()
    {
        $blokList = BlokAsrama::all();
        return view('pengurus.kamar.create', compact('blokList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'blok_asrama_id' => 'required|exists:blok_asrama,id',
            'nomor_kamar' => 'required|string|max:20',
            'kapasitas' => 'required|integer|min:1'
        ]);

        Kamar::create($request->all());

        return redirect()->route('pengurus.kamar.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit(Kamar $kamar)
    {
        $blokList = BlokAsrama::all();
        return view('pengurus.kamar.edit', compact('kamar', 'blokList'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'blok_asrama_id' => 'required|exists:blok_asrama,id',
            'nomor_kamar' => 'required|string|max:20',
            'kapasitas' => 'required|integer|min:1'
        ]);

        $kamar->update($request->all());

        return redirect()->route('pengurus.kamar.index')->with('success', 'Kamar berhasil diupdate.');
    }

    public function destroy(Kamar $kamar)
    {
        if($kamar->users()->count() > 0) {
            return back()->with('error', 'Kamar tidak dapat dihapus karena masih ada penghuni.');
        }
        
        $kamar->delete();
        return redirect()->route('pengurus.kamar.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
