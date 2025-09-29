<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->integer('district_id')->nullable()->after('postal_code');
            $table->string('district_name')->nullable()->after('district_id');
        });
    }

    public function down()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropColumn(['district_id', 'district_name']);
        });
    }
};