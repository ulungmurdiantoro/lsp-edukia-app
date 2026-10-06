<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Booklet kini hanya satu dokumen yang langsung dibuka dalam mode baca — tanpa daftar,
     * jadi deskripsi, sampul, dan urutan tidak dipakai lagi.
     */
    public function up(): void
    {
        Schema::table('booklets', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'cover', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::table('booklets', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('judul');
            $table->string('cover')->nullable()->after('deskripsi');
            $table->unsignedInteger('urutan')->default(0)->after('tampil');
        });
    }
};
