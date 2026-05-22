<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Runs only when the original migration was already executed with the old status column.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            if (! Schema::hasColumn('sertifikats', 'tanggal_kadaluarsa')) {
                $table->date('tanggal_kadaluarsa')->nullable()->after('tanggal_terbit');
            }
            if (Schema::hasColumn('sertifikats', 'status')) {
                $table->dropColumn('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            if (Schema::hasColumn('sertifikats', 'tanggal_kadaluarsa')) {
                $table->dropColumn('tanggal_kadaluarsa');
            }
            if (! Schema::hasColumn('sertifikats', 'status')) {
                $table->enum('status', ['aktif', 'expiring'])->default('aktif')->after('tanggal_terbit');
            }
        });
    }
};
