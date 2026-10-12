<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BlokAsrama;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('kamar.blokAsrama')->where('role', 'penghuni');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('blok')) {
            $query->whereHas('kamar.blokAsrama', function ($q) use ($request) {
                $q->where('id', $request->blok);
            });
        }

        $penghuni = $query->paginate(20);
        $bloks = BlokAsrama::all();

        return view('pengurus.monitoring.index', compact('penghuni', 'bloks'));
    }
}
