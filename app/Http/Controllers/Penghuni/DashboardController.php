<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('penghuni.dashboard', compact('user'));
    }
    
    public function riwayat()
    {
        $user = Auth::user();
        $absensi = $user->absensiHarian()->orderBy('waktu_absensi', 'desc')->paginate(10);
        return view('penghuni.riwayat', compact('absensi'));
    }
}
