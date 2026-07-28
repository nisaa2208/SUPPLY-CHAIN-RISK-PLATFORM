<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('author')->nullable();
            $table->string('source')->nullable();

            $table->string('category')->default('General');

            $table->text('summary')->nullable();
            $table->longText('content')->nullable();

            $table->string('image')->nullable();
            $table->string('url')->nullable();

            $table->enum('status', [
                'Draft',
                'Published'
            ])->default('Draft');

            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};