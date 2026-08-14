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
        Schema::create('organisasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150)->comment('Nama HMPS atau UKM');
            $table->enum('tipe', ['HMPS', 'UKM'])->comment('Jenis organisasi');
            $table->string('prodi_terkait', 150)->nullable()->comment('Program studi terkait (untuk HMPS)');
            $table->string('singkatan', 20)->nullable()->comment('Singkatan nama organisasi');
            $table->text('deskripsi')->nullable();
            $table->string('logo')->nullable()->comment('Path file logo');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tambahkan foreign key ke users setelah tabel organisasi dibuat
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('organisasi_id')->references('id')->on('organisasi')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organisasi_id']);
        });
        Schema::dropIfExists('organisasi');
    }
};
