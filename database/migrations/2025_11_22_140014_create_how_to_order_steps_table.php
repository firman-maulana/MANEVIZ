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
        Schema::create('how_to_order_steps', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->default(0); // Untuk urutan step
            $table->text('content_id'); // Konten bahasa Indonesia
            $table->text('content_en'); // Konten bahasa Inggris
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('how_to_order_steps');
    }
};
