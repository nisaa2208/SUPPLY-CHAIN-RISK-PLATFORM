<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {

        Schema::create('products', function (Blueprint $table) {

            $table->id();


            $table->foreignId('country_id')
                    ->constrained()
                    ->onDelete('cascade');


            $table->foreignId('supplier_id')
                    ->constrained()
                    ->onDelete('cascade');


            $table->string('name');

            $table->string('category');

            $table->integer('stock');

            $table->string('shipping_status');

            $table->integer('risk_score');

            $table->timestamps();

        });

    }


    public function down()
    {

        Schema::dropIfExists('products');

    }

};