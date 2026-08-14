<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckPenangananSensitif
{
    /**
     * Middleware KRITIS untuk melindungi route pengaduan sensitif.
     * 
     * Hanya user dengan permission 'penanganan_kasus_sensitif' yang bisa akses.
     * Setiap akses ke route ini otomatis dicatat ke log untuk audit trail.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Cek permission khusus
        if (!$user->can('penanganan_kasus_sensitif')) {
            // Log upaya akses tidak sah
            Log::warning('AKSES DITOLAK — Route Sensitif', [
                'user_id'    => $user->id,
                'user_email' => $user->email,
                'user_nama'  => $user->nama,
                'role'       => $user->getRoleNames()->toArray(),
                'route'      => $request->route()?->getName(),
                'url'        => $request->fullUrl(),
                'ip'         => $request->ip(),
                'waktu'      => now()->toIso8601String(),
            ]);

            abort(403, 'Anda tidak memiliki izin untuk mengakses data pengaduan sensitif.');
        }

        // Log akses yang sah (audit trail)
        activity('akses_route_sensitif')
            ->causedBy($user)
            ->withProperties([
                'route'    => $request->route()?->getName(),
                'url'      => $request->fullUrl(),
                'method'   => $request->method(),
                'ip'       => $request->ip(),
            ])
            ->log("Staff {$user->nama} mengakses route pengaduan sensitif: {$request->path()}");

        return $next($request);
    }
}
