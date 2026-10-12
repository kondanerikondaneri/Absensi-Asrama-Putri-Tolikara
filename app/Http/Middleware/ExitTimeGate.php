<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExitTimeGate
{
    /**
     * Handle an incoming request.
     * Izin keluar (gate pass) hanya berlaku antara jam 05:00 - 22:00.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $now = Carbon::now();
        $start = Carbon::createFromTime(5, 0, 0); // 05:00
        $end = Carbon::createFromTime(22, 0, 0); // 22:00

        if (!$now->between($start, $end)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Izin keluar hanya diizinkan antara pukul 05:00 - 22:00.'], 403);
            }
            return redirect()->back()->with('error', 'Izin keluar hanya diizinkan antara pukul 05:00 - 22:00.');
        }

        return $next($request);
    }
}
