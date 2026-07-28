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
        Schema::table('countries', function (Blueprint $table) {
            if (!Schema::hasColumn('countries', 'supply_status')) {
                $table->string('supply_status')->nullable()->default('Normal')->after('shipping_status');
            }
            if (!Schema::hasColumn('countries', 'gdp')) {
                $table->string('gdp')->nullable()->after('trade_index');
            }
            if (!Schema::hasColumn('countries', 'inflation')) {
                $table->decimal('inflation', 5, 2)->nullable()->default(2.50)->after('gdp');
            }
            if (!Schema::hasColumn('countries', 'population')) {
                $table->bigInteger('population')->nullable()->after('inflation');
            }
            if (!Schema::hasColumn('countries', 'currency')) {
                $table->string('currency')->nullable()->default('USD')->after('population');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            if (Schema::hasColumn('countries', 'supply_status')) $table->dropColumn('supply_status');
            if (Schema::hasColumn('countries', 'gdp')) $table->dropColumn('gdp');
            if (Schema::hasColumn('countries', 'inflation')) $table->dropColumn('inflation');
            if (Schema::hasColumn('countries', 'population')) $table->dropColumn('population');
            if (Schema::hasColumn('countries', 'currency')) $table->dropColumn('currency');
        });
    }
};
