<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_sertifikasis', function (Blueprint $table) {
            // online | offline — jadwal yang sudah ada otomatis bernilai 'online' lewat default kolom.
            $table->string('metode', 10)->default('online')->after('tanggal_sertifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_sertifikasis', function (Blueprint $table) {
            $table->dropColumn('metode');
        });
    }
};
