<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlokAsrama;

class BlokController extends Controller
{
    public function index()
    {
        $blok = BlokAsrama::paginate(10);
        return view('pengurus.blok.index', compact('blok'));
    }

    public function create()
    {
        return view('pengurus.blok.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_blok' => 'required|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        BlokAsrama::create($request->all());

        return redirect()->route('pengurus.blok.index')->with('success', 'Blok Asrama berhasil ditambahkan.');
    }

    public function edit(BlokAsrama $blok)
    {
        return view('pengurus.blok.edit', compact('blok'));
    }

    public function update(Request $request, BlokAsrama $blok)
    {
        $request->validate([
            'nama_blok' => 'required|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        $blok->update($request->all());

        return redirect()->route('pengurus.blok.index')->with('success', 'Blok Asrama berhasil diupdate.');
    }

    public function destroy(BlokAsrama $blok)
    {
        if($blok->kamar()->count() > 0) {
            return back()->with('error', 'Blok tidak dapat dihapus karena masih ada kamar di dalamnya.');
        }
        
        $blok->delete();
        return redirect()->route('pengurus.blok.index')->with('success', 'Blok Asrama berhasil dihapus.');
    }
}
