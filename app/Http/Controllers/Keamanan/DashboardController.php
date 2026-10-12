<?php

namespace App\Http\Controllers\Keamanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Data cepat untuk dashboard keamanan
        $totalPenghuni = User::where('role', 'penghuni')->count();
        $sedangKeluar = User::where('role', 'penghuni')->where('status', 'sedang_di_luar')->count();
        
        return view('keamanan.dashboard', compact('totalPenghuni', 'sedangKeluar'));
    }
}
