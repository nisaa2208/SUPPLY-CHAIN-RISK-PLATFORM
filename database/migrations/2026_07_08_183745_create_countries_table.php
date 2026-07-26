<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('code',2)->unique();
            $table->string('iso3',3)->nullable();

            $table->string('capital');

            $table->string('region');

            $table->string('sub_region')->nullable();

            $table->string('currency');

            $table->bigInteger('population')->nullable();

            $table->decimal('gdp',18,2)->nullable();

            $table->decimal('latitude',10,6)->nullable();

            $table->decimal('longitude',10,6)->nullable();

            $table->enum('risk_level',[
                'Low',
                'Medium',
                'High'
            ])->default('Low');

            $table->integer('risk_score')->default(0);

            $table->integer('trade_index')->default(0);

            $table->string('supply_status')->default('Normal');

            $table->string('shipping_status')->default('Open');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};