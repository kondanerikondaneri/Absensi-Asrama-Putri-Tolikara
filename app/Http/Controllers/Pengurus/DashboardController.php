<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BlokAsrama;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_penghuni' => User::where('role', 'penghuni')->count(),
            'total_kamar' => \App\Models\Kamar::count(),
            'total_blok' => BlokAsrama::count(),
            'di_luar' => User::where('role', 'penghuni')->where('status', 'sedang_di_luar')->count(),
        ];
        
        return view('pengurus.dashboard', compact('stats'));
    }
}
