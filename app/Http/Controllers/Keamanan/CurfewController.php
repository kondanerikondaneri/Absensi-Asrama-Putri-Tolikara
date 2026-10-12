<?php

namespace App\Http\Controllers\Keamanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlokAsrama;
use App\Models\User;
use App\Models\CurfewCheck;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CurfewController extends Controller
{
    public function index()
    {
        $blokAsrama = BlokAsrama::withCount(['kamar as total_penghuni' => function ($query) {
            $query->join('users', 'kamar.id', '=', 'users.kamar_id');
        }])->get();

        return view('keamanan.curfew_index', compact('blokAsrama'));
    }

    public function showBlok(BlokAsrama $blok)
    {
        $kamarList = $blok->kamar()->with(['users' => function($q) {
            $q->where('role', 'penghuni');
        }])->get();
        
        $today = Carbon::today();
        
        // Cek siapa saja yang sudah di-check hari ini
        $checkedUsers = CurfewCheck::where('tanggal_cek', $today)
            ->whereIn('user_id', $blok->kamar()->join('users', 'kamar.id', '=', 'users.kamar_id')->pluck('users.id'))
            ->pluck('is_hadir', 'user_id');

        return view('keamanan.curfew_blok', compact('blok', 'kamarList', 'checkedUsers'));
    }

    public function check(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'is_hadir' => 'required|boolean',
            'catatan' => 'nullable|string'
        ]);

        $today = Carbon::today();

        CurfewCheck::updateOrCreate(
            ['user_id' => $request->user_id, 'tanggal_cek' => $today],
            [
                'checked_by' => Auth::id(),
                'metode' => 'manual',
                'is_hadir' => $request->is_hadir,
                'catatan' => $request->catatan,
                'waktu_cek' => now()
            ]
        );

        return response()->json(['success' => true]);
    }
    
    public function batchSubmit(Request $request)
    {
        $request->validate([
            'checks' => 'required|array',
            'checks.*.user_id' => 'required|exists:users,id',
            'checks.*.is_hadir' => 'required|boolean'
        ]);
        
        $today = Carbon::today();
        $adminId = Auth::id();
        
        foreach ($request->checks as $check) {
            CurfewCheck::updateOrCreate(
                ['user_id' => $check['user_id'], 'tanggal_cek' => $today],
                [
                    'checked_by' => $adminId,
                    'metode' => 'manual',
                    'is_hadir' => $check['is_hadir'],
                    'waktu_cek' => now()
                ]
            );
        }
        
        return redirect()->route('keamanan.curfew')->with('success', 'Apel malam berhasil disimpan.');
    }

    public function riwayat()
    {
        $riwayat = CurfewCheck::with(['user.kamar.blokAsrama', 'checker'])
            ->orderBy('waktu_cek', 'desc')
            ->paginate(20);
            
        return view('keamanan.curfew_riwayat', compact('riwayat'));
    }
}
