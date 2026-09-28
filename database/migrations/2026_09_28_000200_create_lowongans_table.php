<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // disimpan juga di lamaran_karirs.posisi
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('kategori');
            $table->string('lokasi');
            $table->string('tipe');
            $table->json('requirements');
            $table->json('responsibilities');
            $table->boolean('tampil')->default(true);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });

        // Lowongan yang sebelumnya ditulis langsung di KarierController::getOpenings().
        DB::table('lowongans')->insert([
            'slug' => 'management-representative',
            'judul' => 'Management Representative (MR) - LSP Edukia',
            'deskripsi' => 'Kami mencari Management Representative yang berpengalaman untuk bergabung dengan tim LSP Edukia. Posisi ini bertanggung jawab atas pengelolaan sistem mutu dan audit internal.',
            'kategori' => 'Management',
            'lokasi' => 'Mijen, Semarang Barat',
            'tipe' => 'Full-time',
            'requirements' => json_encode([
                'Pendidikan minimal S1',
                'Pengalaman kerja di bidang Penjaminan Mutu minimal 1 tahun',
                'Memiliki sertifikat kompetensi di bidang ISO 21001 atau ISO 17024 (lebih diutamakan)',
                'Terampil dalam mengelola audit internal dan sistem mutu',
                'Mampu berkomunikasi dengan baik',
                'Bersedia bekerja penuh waktu (full-time) di lokasi Mijen, Semarang Barat',
            ]),
            'responsibilities' => json_encode([
                'Mengelola dan mengembangkan sistem mutu organisasi',
                'Melakukan audit internal secara berkala',
                'Membuat laporan mutu kepada manajemen',
                'Memastikan kepatuhan terhadap standar ISO 21001',
                'Berkoordinasi dengan berbagai departemen untuk perbaikan berkelanjutan',
            ]),
            'tampil' => true,
            'urutan' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};
