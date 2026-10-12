<?php

namespace App\Services;

use App\Models\AbsensiHarian;
use Illuminate\Support\Facades\Auth;

class AbsensiService
{
    protected $geoService;

    public function __construct(GeolocationService $geoService)
    {
        $this->geoService = $geoService;
    }

    /**
     * Memproses absensi berbasis GPS
     */
    public function processGpsAbsensi($lat, $lng, $ipAddress, $userAgent)
    {
        $geoCheck = $this->geoService->isWithinRadius($lat, $lng);
        
        $status = $geoCheck['valid'] ? 'berhasil' : 'di_luar_radius';

        $absensi = AbsensiHarian::create([
            'user_id' => Auth::id(),
            'metode' => 'gps',
            'latitude' => $lat,
            'longitude' => $lng,
            'jarak_meter' => $geoCheck['distance'],
            'status' => $status,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);

        return $absensi;
    }

    /**
     * Memproses absensi berbasis QR Code
     */
    public function processQrAbsensi($qrCodeValue, $ipAddress, $userAgent)
    {
        // Pengecekan validitas QR code
        $qrService = app(QrCodeService::class);
        $isValid = $qrService->validateQrCode($qrCodeValue);
        
        $status = $isValid ? 'berhasil' : 'gagal';

        $absensi = AbsensiHarian::create([
            'user_id' => Auth::id(),
            'metode' => 'qr_code',
            'qr_code_value' => $qrCodeValue,
            'status' => $status,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);

        return $absensi;
    }
}
