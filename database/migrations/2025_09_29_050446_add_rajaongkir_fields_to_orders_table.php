<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add RajaOngkir related fields
            $table->string('courier_code')->nullable()->after('shipping_cost'); // jne, tiki, pos, etc
            $table->string('courier_service')->nullable()->after('courier_code'); // REG, YES, OKE, etc
            $table->integer('shipping_district_id')->nullable()->after('courier_service'); // RajaOngkir district ID
            $table->integer('total_weight')->nullable()->after('shipping_district_id'); // Total weight in grams
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['courier_code', 'courier_service', 'shipping_district_id', 'total_weight']);
        });
    }
};