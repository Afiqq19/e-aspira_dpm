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
        Schema::create('program_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255)->comment('Nama Program Kerja');
            $table->text('deskripsi')->nullable()->comment('Detail program kerja');
            $table->foreignId('organisasi_id')->constrained('organisasi')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('Akun yg mendaftarkan');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['rencana', 'berjalan', 'selesai', 'dibatalkan'])->default('rencana');
            $table->enum('kategori', ['akademik', 'sosial', 'olahraga', 'seni', 'lainnya'])->default('lainnya');
            $table->boolean('is_active')->default(true)->comment('Tampil / tidak untuk evaluasi');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_kerja');
    }
};
