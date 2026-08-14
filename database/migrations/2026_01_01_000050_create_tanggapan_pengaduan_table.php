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
        Schema::create('tanggapan_pengaduan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengaduan_id');
            $table->unsignedBigInteger('user_id')->nullable()->comment('Nullable jika balasan dari sistem/anonim');
            $table->text('isi_tanggapan');
            $table->enum('tipe', ['mahasiswa', 'staff', 'sistem'])
                ->default('mahasiswa')
                ->comment('Asal tanggapan: mahasiswa pelapor, staff dewan, atau sistem otomatis');
            $table->boolean('is_internal')->default(false)->comment('Catatan internal staff, tidak terlihat oleh pelapor');
            $table->string('lampiran')->nullable()->comment('Path file lampiran tambahan');
            $table->timestamps();

            $table->foreign('pengaduan_id')->references('id')->on('pengaduan')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggapan_pengaduan');
    }
};
