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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->enum('subject', ['general', 'support', 'sales', 'partnership', 'other']);
            $table->text('message');
            $table->enum('status', ['new', 'in_progress', 'resolved', 'closed'])->default('new');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
            $table->index('subject');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};