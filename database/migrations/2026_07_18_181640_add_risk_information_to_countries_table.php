<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {

            $table->integer('risk_score')
                  ->default(0)
                  ->after('risk_level');

            $table->integer('trade_index')
                  ->default(0)
                  ->after('risk_score');

            $table->string('supply_status')
                  ->default('Normal')
                  ->after('trade_index');

            $table->string('shipping_status')
                  ->default('Normal')
                  ->after('supply_status');

        });
    }



    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {

            $table->dropColumn([

                'risk_score',
                'trade_index',
                'supply_status',
                'shipping_status'

            ]);

        });
    }

};