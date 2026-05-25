<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            if (! Schema::hasColumn('sertifikats', 'no_sk')) {
                $table->string('no_sk')->nullable()->after('nomor_sertifikat');
            }
            if (! Schema::hasColumn('sertifikats', 'no_skema')) {
                $table->string('no_skema')->nullable()->after('no_sk');
            }
            if (! Schema::hasColumn('sertifikats', 'gelar')) {
                $table->string('gelar')->nullable()->after('nama');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->dropColumn(['no_sk', 'no_skema', 'gelar']);
        });
    }
};
