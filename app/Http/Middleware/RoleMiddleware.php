<?php

// app/Http/Middleware/RoleMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        dd('Middleware berjalan', 'Role yang dibutuhkan:', $role, 'Role Anda:', $request->user()->role);
        // Cek jika role user yang sedang login tidak sama dengan role yang diizinkan
        if ($request->user()->role !== $role) {
            // Jika tidak cocok, arahkan kembali ke halaman dashboard
            return redirect('/dashboard');
        }

        // Jika cocok, lanjutkan ke halaman yang dituju
        return $next($request);
    }
}
