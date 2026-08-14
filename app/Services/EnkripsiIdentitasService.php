<?php

namespace App\Services;

use App\Models\IdentitasTerenkripsi;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class EnkripsiIdentitasService
{
    /**
     * Enkripsi dan simpan identitas pelapor untuk mode anonim.
     *
     * @param Pengaduan $pengaduan
     * @param array $dataDiri
     * @return bool
     */
    public function simpanIdentitas(Pengaduan $pengaduan, array $dataDiri): bool
    {
        try {
            $dataAsli = json_encode($dataDiri);
            $dataTerenkripsi = Crypt::encryptString($dataAsli);

            IdentitasTerenkripsi::create([
                'pengaduan_id' => $pengaduan->id,
                'data_terenkripsi' => $dataTerenkripsi,
                'encrypted_key_ref' => uniqid('ref_'), // Ref identifier for standard compliance
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Gagal mengenkripsi identitas untuk Pengaduan ID ' . $pengaduan->id . ': ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Dekripsi identitas asli (Hanya dipanggil setelah pengecekan permission).
     *
     * @param Pengaduan $pengaduan
     * @return array|null
     */
    public function bukaIdentitas(Pengaduan $pengaduan): ?array
    {
        $identitas = IdentitasTerenkripsi::where('pengaduan_id', $pengaduan->id)->first();
        
        if (!$identitas) {
            return null;
        }

        try {
            $dataAsliJson = Crypt::decryptString($identitas->data_terenkripsi);
            return json_decode($dataAsliJson, true);
        } catch (\Exception $e) {
            Log::error('Gagal mendekripsi identitas untuk Pengaduan ID ' . $pengaduan->id . ': ' . $e->getMessage());
            return null;
        }
    }
}
