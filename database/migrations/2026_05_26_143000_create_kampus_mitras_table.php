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
        Schema::create('kampus_mitras', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kampus');
            $table->string('logo')->nullable();
            $table->text('deskripsi');
            $table->string('website')->nullable();
            $table->string('kontak');
            $table->text('alamat');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kampus_mitras');
    }
};
