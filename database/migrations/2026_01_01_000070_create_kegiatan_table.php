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
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->text('deskripsi')->nullable();
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai')->nullable();
            $table->string('lokasi', 255)->nullable();
            $table->unsignedBigInteger('organisasi_id')->nullable()->comment('Null = kegiatan DPM umum');
            $table->unsignedBigInteger('user_id')->comment('Yang membuat kegiatan');
            $table->string('poster')->nullable()->comment('Path file poster/flyer');
            $table->string('kontak_penanggung_jawab', 100)->nullable();
            $table->string('no_kontak', 20)->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organisasi_id')->references('id')->on('organisasi')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};
