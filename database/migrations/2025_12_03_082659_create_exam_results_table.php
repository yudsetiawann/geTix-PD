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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete(); // Terhubung ke peserta via Order
            $table->foreignId('exam_attribute_id')->constrained()->cascadeOnDelete();
            $table->string('value')->nullable(); // Nilai (bisa angka atau huruf)
            $table->timestamps();

            // Satu peserta hanya punya satu nilai untuk satu atribut
            $table->unique(['order_id', 'exam_attribute_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
