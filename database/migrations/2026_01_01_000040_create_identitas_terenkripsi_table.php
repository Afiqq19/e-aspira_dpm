<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * PENTING: Tabel ini TERPISAH dari tabel pengaduan.
     * Menyimpan identitas asli pelapor anonim dalam format terenkripsi AES-256.
     * Hanya bisa diakses oleh user dengan permission 'penanganan_kasus_sensitif'.
     */
    public function up(): void
    {
        Schema::create('identitas_terenkripsi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengaduan_id')->unique()->comment('Satu pengaduan satu record identitas');
            $table->longText('data_terenkripsi')->comment('Data identitas dienkripsi dengan Laravel Crypt (AES-256-CBC)');
            $table->string('encrypted_key_ref', 255)->nullable()->comment('Referensi kunci enkripsi (untuk key rotation)');
            $table->timestamp('diakses_pada')->nullable()->comment('Terakhir kali identitas dibuka');
            $table->unsignedBigInteger('diakses_oleh')->nullable()->comment('User yang terakhir membuka identitas');
            $table->timestamps();

            $table->foreign('pengaduan_id')->references('id')->on('pengaduan')->cascadeOnDelete();
            $table->foreign('diakses_oleh')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas_terenkripsi');
    }
};
