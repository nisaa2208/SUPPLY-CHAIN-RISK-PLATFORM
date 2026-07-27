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
        Schema::create('countries', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('code')->nullable();

            $table->string('region')->nullable();

            $table->integer('risk_score')->default(0);

            $table->enum('risk_level', [
                'Low',
                'Medium',
                'High'
            ])->default('Low');

            $table->integer('trade_index')->default(0);

            $table->decimal('latitude', 10, 7)->nullable();

            $table->decimal('longitude', 10, 7)->nullable();

            $table->string('shipping_status')->default('Normal');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};