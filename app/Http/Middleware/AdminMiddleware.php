<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request for Admin-only routes.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized. Admin access required.'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Halaman ini khusus untuk Administrator.');
        }

        return $next($request);
    }
}
