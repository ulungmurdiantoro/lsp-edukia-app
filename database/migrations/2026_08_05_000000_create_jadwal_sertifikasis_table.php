<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_sertifikasis', function (Blueprint $table) {
            $table->id();
            $table->string('skema');
            $table->string('bidang'); // spmi, pt, lab17025, lifting, labtest, manajemen, riset — lihat App\Support\Skemas::bidangs()
            $table->date('tanggal_sertifikasi');
            $table->boolean('tampil')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_sertifikasis');
    }
};
