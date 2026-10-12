<?php

namespace App\Services;

class GeolocationService
{
    // Koordinat pusat asrama (contoh)
    const ASRAMA_LAT = -2.53371;
    const ASRAMA_LNG = 140.71813;
    const MAX_RADIUS_METERS = 50.0;

    /**
     * Menghitung jarak antara dua koordinat menggunakan formula Haversine.
     * Mengembalikan jarak dalam satuan meter.
     */
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }

    /**
     * Mengecek apakah koordinat user berada di dalam radius asrama.
     */
    public function isWithinRadius($lat, $lng)
    {
        $distance = $this->calculateDistance($lat, $lng, self::ASRAMA_LAT, self::ASRAMA_LNG);
        return [
            'valid' => $distance <= self::MAX_RADIUS_METERS,
            'distance' => $distance
        ];
    }
}
