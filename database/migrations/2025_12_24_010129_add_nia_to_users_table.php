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
        Schema::table('users', function (Blueprint $table) {
            // NIA: 4 digit tahun + 8 digit TTL + 4 digit urut = 16 digit (String aman)
            $table->string('nia', 20)->nullable()->unique()->after('id')
                ->comment('Nomor Induk Anggota: TahunMasuk + TTL + Urut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nia');
        });
    }
};
