<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriPengaduan;

class KategoriPengaduanSeeder extends Seeder
{
    /**
     * Seed 5 kategori pengaduan sesuai spesifikasi e-Aspira DPM Polmed.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori'     => 'Akademik',
                'level_sensitivitas' => 'normal',
                'deskripsi'         => 'Pengaduan terkait proses belajar mengajar, kurikulum, nilai, dosen, dan segala aspek akademik.',
            ],
            [
                'nama_kategori'     => 'Fasilitas',
                'level_sensitivitas' => 'normal',
                'deskripsi'         => 'Pengaduan terkait sarana dan prasarana kampus seperti gedung, laboratorium, toilet, parkir, wifi, dan fasilitas umum lainnya.',
            ],
            [
                'nama_kategori'     => 'Kemahasiswaan / Organisasi',
                'level_sensitivitas' => 'normal',
                'deskripsi'         => 'Pengaduan terkait kegiatan kemahasiswaan, himpunan, UKM, beasiswa, dan pelayanan kemahasiswaan.',
            ],
            [
                'nama_kategori'     => 'Pelecehan / Kekerasan',
                'level_sensitivitas' => 'sensitif',
                'deskripsi'         => 'Pengaduan terkait pelecehan seksual, perundungan (bullying), kekerasan fisik maupun verbal, dan segala bentuk tindak kekerasan di lingkungan kampus. HANYA ditangani oleh staff dengan izin khusus.',
            ],
            [
                'nama_kategori'     => 'Lainnya',
                'level_sensitivitas' => 'normal',
                'deskripsi'         => 'Pengaduan atau aspirasi yang tidak termasuk dalam kategori di atas.',
            ],
        ];

        foreach ($kategoris as $kategori) {
            KategoriPengaduan::firstOrCreate(
                ['nama_kategori' => $kategori['nama_kategori']],
                $kategori
            );
        }

        $this->command->info('✅ 5 kategori pengaduan dibuat.');
        $this->command->warn('⚠️  Kategori "Pelecehan / Kekerasan" ditandai SENSITIF — hanya bisa diakses oleh staff dengan permission penanganan_kasus_sensitif.');
    }
}
