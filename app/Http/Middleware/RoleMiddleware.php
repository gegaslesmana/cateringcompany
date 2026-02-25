<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response; // PASTIKAN IMPORT INI BENAR

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek jika tidak login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role sesuai (case-insensitive)
        if (strtolower(Auth::user()->role) !== strtolower($role)) {
            abort(403, 'Unauthorized. Role Anda (' . Auth::user()->role . ') tidak memiliki akses.');
        }

        return $next($request);
    }
}