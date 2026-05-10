<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * Memeriksa apakah user yang terautentikasi memiliki role yang diizinkan.
     * Penggunaan di route: middleware('role:1,2') untuk Admin & Pembimbing.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Role IDs yang diizinkan (1=Admin, 2=Pembimbing, 3=Pelaksana)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRoleId = (string) auth()->user()->role_id;

        if (!in_array($userRoleId, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
