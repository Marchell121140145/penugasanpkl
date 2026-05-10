<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     * 
     * Menambahkan HTTP Security Headers pada setiap response
     * untuk melindungi dari clickjacking, MIME sniffing, dan XSS.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Mencegah halaman di-embed dalam iframe oleh domain lain (anti-clickjacking)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Mencegah browser melakukan MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Aktifkan filter XSS bawaan browser
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Kontrol informasi referrer yang dikirim ke situs lain
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Batasi akses ke fitur browser (kamera, mikrofon, geolokasi)
        $response->headers->set('Permissions-Policy', 'camera=(self), microphone=(), geolocation=(self)');

        return $response;
    }
}
