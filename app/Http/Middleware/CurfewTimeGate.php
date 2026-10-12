<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CurfewTimeGate
{
    /**
     * Handle an incoming request.
     * Curfew check / Apel malam hanya valid dilakukan antara 22:00 - 23:00.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $now = Carbon::now();
        $start = Carbon::createFromTime(22, 0, 0); // 22:00
        $end = Carbon::createFromTime(23, 0, 0); // 23:00

        // Allow bypassing check if we want admin to manually add records late, 
        // but by default enforce for security apps.
        if (!$now->between($start, $end)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Pengecekan apel malam hanya dapat dilakukan antara pukul 22:00 - 23:00.'], 403);
            }
            return redirect()->back()->with('error', 'Pengecekan apel malam hanya dapat dilakukan antara pukul 22:00 - 23:00.');
        }

        return $next($request);
    }
}
