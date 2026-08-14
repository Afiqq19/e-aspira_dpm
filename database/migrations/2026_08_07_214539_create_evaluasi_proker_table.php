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
        Schema::create('evaluasi_proker', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_kerja_id')->constrained('program_kerja')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('Mahasiswa pengevaluasi');
            $table->tinyInteger('rating')->unsigned()->comment('Rating 1-5 bintang');
            $table->text('komentar')->comment('Isi evaluasi / kritik / saran');
            $table->enum('aspek', ['pendaftaran', 'pelaksanaan', 'manfaat', 'koordinasi', 'lainnya'])->default('lainnya');
            $table->boolean('is_anonim')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi_proker');
    }
};
