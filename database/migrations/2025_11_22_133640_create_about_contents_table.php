<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_contents', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable(); // Path gambar
            $table->text('paragraph_1'); // Paragraf pertama
            $table->text('paragraph_2'); // Paragraf kedua
            $table->text('paragraph_3'); // Paragraf ketiga
            $table->text('paragraph_4'); // Paragraf keempat
            $table->text('paragraph_5'); // Paragraf kelima (tagline)
            $table->boolean('is_active')->default(true); // Hanya 1 yang aktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_contents');
    }
};
