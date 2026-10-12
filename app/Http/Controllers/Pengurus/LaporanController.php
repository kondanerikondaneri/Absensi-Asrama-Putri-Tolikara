<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AbsensiHarian;
use App\Models\CurfewCheck;
use App\Models\AbsenKeluar;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tipe = $request->get('tipe', 'absensi_harian');
        
        $data = [];
        
        if ($tipe === 'absensi_harian') {
            $data = AbsensiHarian::with('user.kamar.blokAsrama')
                ->orderBy('waktu_absensi', 'desc')
                ->paginate(20);
        } elseif ($tipe === 'izin_keluar') {
            $data = AbsenKeluar::with('user.kamar.blokAsrama')
                ->orderBy('waktu_keluar', 'desc')
                ->paginate(20);
        } elseif ($tipe === 'curfew') {
            $data = CurfewCheck::with(['user.kamar.blokAsrama', 'checker'])
                ->orderBy('waktu_cek', 'desc')
                ->paginate(20);
        }

        return view('pengurus.laporan.index', compact('data', 'tipe'));
    }
}
