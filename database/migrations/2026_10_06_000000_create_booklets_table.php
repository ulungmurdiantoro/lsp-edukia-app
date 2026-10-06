<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booklets', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('cover')->nullable(); // disk public, folder booklet/cover
            // Sumber booklet: unggahan PDF (disk public) atau tautan eksternal (Drive, Canva, flipbook).
            // Minimal salah satu terisi; bila keduanya, PDF yang dipakai.
            $table->string('file')->nullable();
            $table->string('link', 2048)->nullable();
            $table->boolean('tampil')->default(true);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booklets');
    }
};
