<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QrCode;
use App\Services\QrCodeService;
use App\Models\Kamar;

class QrCodeController extends Controller
{
    protected $qrService;

    public function __construct(QrCodeService $qrService)
    {
        $this->qrService = $qrService;
    }

    public function index()
    {
        $qrCodes = QrCode::orderBy('created_at', 'desc')->paginate(15);
        return view('pengurus.qr.index', compact('qrCodes'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:lokasi,kamar,identitas',
            'reference_id' => 'nullable|integer',
            'reference_type' => 'nullable|string'
        ]);

        $this->qrService->generateQrCode(
            $request->tipe,
            $request->reference_id,
            $request->reference_type
        );

        return redirect()->route('pengurus.qr.index')->with('success', 'QR Code berhasil di-generate.');
    }
    
    public function destroy(QrCode $qr)
    {
        $qr->update(['is_active' => false]);
        return redirect()->route('pengurus.qr.index')->with('success', 'QR Code dinonaktifkan.');
    }
}
