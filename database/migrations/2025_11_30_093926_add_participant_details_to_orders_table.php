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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('nik')->nullable()->after('phone_number');
            $table->string('kk')->nullable()->after('nik');
            $table->string('birth_place')->nullable()->after('kk');
            $table->date('birth_date')->nullable()->after('birth_place');
            $table->integer('weight')->nullable()->after('birth_date'); // Dalam Kg
            $table->string('class')->nullable()->after('category'); // Kelas Tanding (A-J Putra/i)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['nik', 'kk', 'birth_place', 'birth_date', 'weight', 'class']);
        });
    }
};
