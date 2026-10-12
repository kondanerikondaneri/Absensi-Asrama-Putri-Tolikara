<?php

namespace App\Services;

use App\Models\QrCode;
use Illuminate\Support\Str;

class QrCodeService
{
    /**
     * Memvalidasi apakah kode QR terdaftar dan masih aktif.
     */
    public function validateQrCode($kode)
    {
        $qr = QrCode::where('kode', $kode)->where('is_active', true)->first();
        return $qr !== null;
    }

    /**
     * Men-generate kode QR unik baru untuk lokasi/kamar/identitas
     */
    public function generateQrCode($tipe, $referenceId = null, $referenceType = null)
    {
        $kode = Str::uuid()->toString();
        
        return QrCode::create([
            'kode' => $kode,
            'tipe' => $tipe,
            'reference_id' => $referenceId,
            'reference_type' => $referenceType,
            'is_active' => true
        ]);
    }
}
