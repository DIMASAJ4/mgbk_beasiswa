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
        Schema::create('rekomendasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_siswa_id')->constrained('data_siswas')->onDelete('cascade');
            $table->foreignId('beasiswa_id')->constrained('beasiswas')->onDelete('cascade');
            $table->foreignId('guru_bk_id')->constrained('users')->onDelete('cascade');
            $table->integer('persentase_kecocokan');
            $table->enum('status', ['menunggu', 'terverifikasi', 'revisi', 'dikirim']);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasis');
    }
};
