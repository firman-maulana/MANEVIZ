<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refund_policies', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique(); // 'refund_policy' or 'exchange_policy'
            $table->string('title_id');
            $table->string('title_en');
            $table->text('content_id');
            $table->text('content_en');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refund_policies');
    }
};
