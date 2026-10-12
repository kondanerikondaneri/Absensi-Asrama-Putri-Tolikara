<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AbsenKeluar;
use Illuminate\Support\Facades\Auth;

class IzinKeluarController extends Controller
{
    public function index()
    {
        $activeKeluar = Auth::user()->absenKeluar()->whereNull('waktu_kembali')->first();
        return view('penghuni.izin_keluar', compact('activeKeluar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255'
        ]);

        // Cek jika masih ada izin yang belum kembali
        $activeKeluar = Auth::user()->absenKeluar()->whereNull('waktu_kembali')->first();
        if ($activeKeluar) {
            return back()->with('error', 'Anda masih memiliki status keluar yang belum ditutup.');
        }

        Auth::user()->absenKeluar()->create([
            'keterangan' => $request->keterangan,
        ]);
        
        Auth::user()->update(['status' => 'sedang_di_luar']);

        return redirect()->route('penghuni.dashboard')->with('success', 'Izin keluar berhasil dicatat.');
    }

    public function kembali(Request $request)
    {
        $activeKeluar = Auth::user()->absenKeluar()->whereNull('waktu_kembali')->first();
        if (!$activeKeluar) {
            return back()->with('error', 'Tidak ada data izin keluar yang aktif.');
        }

        $activeKeluar->update([
            'waktu_kembali' => now()
        ]);
        
        Auth::user()->update(['status' => 'di_asrama']);

        return redirect()->route('penghuni.dashboard')->with('success', 'Status kembali berhasil dicatat.');
    }
}
