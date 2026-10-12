<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AbsensiService;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    protected $absensiService;

    public function __construct(AbsensiService $absensiService)
    {
        $this->absensiService = $absensiService;
    }

    public function index()
    {
        // Pastikan belum absen hari ini
        $sudahAbsen = Auth::user()->absensiHarian()
                        ->whereDate('waktu_absensi', now()->toDateString())
                        ->exists();

        return view('penghuni.absensi', compact('sudahAbsen'));
    }

    public function absenGps(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $absensi = $this->absensiService->processGpsAbsensi(
            $request->latitude,
            $request->longitude,
            $request->ip(),
            $request->userAgent()
        );

        if ($absensi->status == 'berhasil') {
            return response()->json(['success' => true, 'message' => 'Absensi GPS berhasil.']);
        }

        return response()->json(['success' => false, 'message' => 'Anda berada di luar jangkauan asrama. Jarak: ' . round($absensi->jarak_meter, 2) . ' meter.']);
    }

    public function absenQr(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $absensi = $this->absensiService->processQrAbsensi(
            $request->qr_code,
            $request->ip(),
            $request->userAgent()
        );

        if ($absensi->status == 'berhasil') {
            return response()->json(['success' => true, 'message' => 'Absensi QR Code berhasil.']);
        }

        return response()->json(['success' => false, 'message' => 'QR Code tidak valid atau sudah kadaluarsa.']);
    }

    public function absenManual(Request $request)
    {
        // Hanya untuk fallback jika GPS dan QR gagal (butuh validasi pengurus nanti)
        Auth::user()->absensiHarian()->create([
            'metode' => 'manual',
            'status' => 'berhasil',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
        
        return redirect()->route('penghuni.dashboard')->with('success', 'Absensi manual berhasil dicatat.');
    }
}
