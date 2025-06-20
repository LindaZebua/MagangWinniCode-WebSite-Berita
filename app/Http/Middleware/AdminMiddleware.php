<?php

namespace App\Http\Middleware; // Pastikan namespace ini benar dan tidak ada typo

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware // Pastikan nama kelas ini sama persis dengan nama file
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Anda bukan admin.');
    }
}