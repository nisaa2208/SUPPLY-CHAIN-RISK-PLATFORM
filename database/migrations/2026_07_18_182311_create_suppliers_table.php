<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {

        Schema::create('suppliers', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                    ->constrained()
                    ->onDelete('cascade');


            $table->string('name');

            $table->string('email');

            $table->string('phone');

            $table->text('address');

            $table->string('supply_status');

            $table->integer('risk_score');

            $table->timestamps();

        });

    }



    public function down()
    {

        Schema::dropIfExists('suppliers');

    }

};