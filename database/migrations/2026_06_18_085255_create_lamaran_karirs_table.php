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
        Schema::create('lamaran_karirs', function (Blueprint $table) {
            $table->id();
            $table->string('posisi'); // job slug like 'management-representative'
            $table->string('nama_lengkap');
            $table->string('tempat_tanggal_lahir');
            $table->string('nomor_whatsapp');
            $table->string('domisili');
            $table->string('pendidikan_terakhir'); // S1, S2, S3
            $table->string('jurusan');
            $table->string('pengalaman_kerja'); // <1, 1-3, 3-5, >5 tahun
            $table->string('sertifikat_iso'); // YA, TIDAK
            $table->text('sertifikat_list')->nullable();
            $table->text('pengalaman_audit');
            $table->string('cv'); // file path
            $table->string('portofolio')->nullable();
            $table->string('ijazah');
            $table->string('sertifikat_pelatihan');
            $table->boolean('bersedia_fulltime')->default(true);
            $table->string('status')->default('submitted'); // submitted, reviewed, rejected, accepted
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
            $table->index(['posisi', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lamaran_karirs');
    }
};
