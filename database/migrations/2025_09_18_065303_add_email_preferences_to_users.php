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
            $table->boolean('receive_new_product_emails')->default(true)->after('is_active');
            $table->boolean('receive_promotional_emails')->default(true)->after('receive_new_product_emails');
            $table->timestamp('last_email_sent_at')->nullable()->after('receive_promotional_emails');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'receive_new_product_emails',
                'receive_promotional_emails', 
                'last_email_sent_at'
            ]);
        });
    }
};

