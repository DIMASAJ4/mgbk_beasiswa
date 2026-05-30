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
        Schema::create('beasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kampus_mitra_id')->constrained('kampus_mitras')->onDelete('cascade');
            $table->string('nama_beasiswa');
            $table->text('deskripsi');
            $table->enum('jenis', ['full_funding', 'partial_funding', 'akomodasi']);
            $table->json('persyaratan');
            $table->integer('kuota');
            $table->date('deadline');
            $table->enum('status', ['aktif', 'draft', 'tutup']);
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beasiswas');
    }
};
