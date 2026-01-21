<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('waybill_number')->nullable()->after('courier_service');
            $table->json('tracking_history')->nullable()->after('waybill_number');
            $table->timestamp('last_tracking_update')->nullable()->after('tracking_history');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['waybill_number', 'tracking_history', 'last_tracking_update']);
        });
    }
};
