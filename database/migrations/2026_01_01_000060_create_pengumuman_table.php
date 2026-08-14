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
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->longText('isi');
            $table->unsignedBigInteger('organisasi_id')->nullable()->comment('Null = pengumuman DPM umum');
            $table->unsignedBigInteger('user_id')->comment('Yang membuat pengumuman');
            $table->string('kategori', 50)->nullable()->comment('Kategori/tag pengumuman');
            $table->json('tags')->nullable()->comment('Array tag untuk filter');
            $table->boolean('is_pinned')->default(false)->comment('Disematkan di halaman utama');
            $table->string('lampiran')->nullable()->comment('Path file gambar/PDF');
            $table->timestamp('dipublikasikan_pada')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('published');
            $table->timestamps();
            $table->softDeletes()->comment('Soft delete — arsip, tidak dihapus permanen');

            $table->foreign('organisasi_id')->references('id')->on('organisasi')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};
