<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code', 20)->unique()->comment('Format: PLP-YYYY-XXXX');
            $table->unsignedBigInteger('user_id')->nullable()->comment('Nullable untuk mode anonim');
            $table->unsignedBigInteger('kategori_id');
            $table->text('isi')->comment('Isi pengaduan/aspirasi');
            $table->enum('mode_privasi', ['umum', 'anonim'])
                ->default('umum')
                ->comment('umum = identitas terlihat staff, anonim = identitas terenkripsi');
            $table->enum('status', [
                'diterima',
                'diverifikasi',
                'diproses',
                'ditindaklanjuti',
                'selesai',
                'ditolak',
            ])->default('diterima');
            $table->boolean('penanganan_khusus')
                ->default(false)
                ->comment('True jika kategori sensitif, memerlukan permission khusus');
            $table->string('kode_anonim', 20)->nullable()->comment('Kode acak pengganti nama untuk mode anonim');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamp('ditangani_pada')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('kategori_id')->references('id')->on('kategori_pengaduan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
