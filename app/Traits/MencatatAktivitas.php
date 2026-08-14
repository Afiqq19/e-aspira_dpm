<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait MencatatAktivitas
{
    /**
     * Catat log aktivitas sensitif ke database menggunakan spatie/laravel-activitylog.
     *
     * @param string $aksi (misal: "membuka_identitas_anonim")
     * @param mixed $model Model yang ditargetkan (misal instans Pengaduan)
     * @param array $properties Data tambahan (opsional)
     */
    public function catatLogSensitif(string $aksi, $model = null, array $properties = [])
    {
        $log = activity()
            ->causedBy(Auth::user())
            ->withProperties($properties)
            ->event($aksi);

        if ($model) {
            $log->performedOn($model);
        }

        $log->log('Akses atau tindakan pada data sensitif dilakukan.');
    }
}
