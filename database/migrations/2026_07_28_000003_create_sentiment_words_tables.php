<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations (PDF Spec Hal 7: positive_words & negative_words tables).
     */
    public function up(): void
    {
        if (!Schema::hasTable('positive_words')) {
            Schema::create('positive_words', function (Blueprint $table) {
                $table->id();
                $table->string('word')->unique();
                $table->timestamps();
            });

            DB::table('positive_words')->insert([
                ['word' => 'growth'], ['word' => 'increase'], ['word' => 'profit'],
                ['word' => 'stable'], ['word' => 'improve'], ['word' => 'boom'],
                ['word' => 'boost'], ['word' => 'surge'], ['word' => 'expansion'],
                ['word' => 'recovery'], ['word' => 'strong'], ['word' => 'positive'],
                ['word' => 'gain'], ['word' => 'solution'], ['word' => 'agreement']
            ]);
        }

        if (!Schema::hasTable('negative_words')) {
            Schema::create('negative_words', function (Blueprint $table) {
                $table->id();
                $table->string('word')->unique();
                $table->timestamps();
            });

            DB::table('negative_words')->insert([
                ['word' => 'war'], ['word' => 'crisis'], ['word' => 'inflation'],
                ['word' => 'delay'], ['word' => 'disaster'], ['word' => 'conflict'],
                ['word' => 'strike'], ['word' => 'decline'], ['word' => 'drop'],
                ['word' => 'decrease'], ['word' => 'loss'], ['word' => 'sanction'],
                ['word' => 'shortage'], ['word' => 'disrupt'], ['word' => 'congestion']
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positive_words');
        Schema::dropIfExists('negative_words');
    }
};
