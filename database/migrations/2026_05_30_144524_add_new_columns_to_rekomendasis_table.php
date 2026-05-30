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
        Schema::table('rekomendasis', function (Blueprint $table) {
            $table->unsignedBigInteger('guru_bk_id')->nullable()->change();
            $table->enum('direkomendasikan_oleh', ['admin', 'guru_bk'])->default('guru_bk')->after('guru_bk_id');
            $table->boolean('dipilih_siswa')->default(false)->after('status');
            $table->timestamp('dipilih_at')->nullable()->after('dipilih_siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekomendasis', function (Blueprint $table) {
            $table->unsignedBigInteger('guru_bk_id')->nullable(false)->change();
            $table->dropColumn(['direkomendasikan_oleh', 'dipilih_siswa', 'dipilih_at']);
        });
    }
};
