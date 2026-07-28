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
        Schema::table('ports', function (Blueprint $table) {
            if (!Schema::hasColumn('ports', 'port_type')) {
                $table->string('port_type')->default('Container Terminal')->after('status');
            }
            if (!Schema::hasColumn('ports', 'congestion_level')) {
                $table->string('congestion_level')->default('Normal')->after('port_type');
            }
            if (!Schema::hasColumn('ports', 'risk_level')) {
                $table->string('risk_level')->default('Low Risk')->after('congestion_level');
            }
            if (!Schema::hasColumn('ports', 'risk_score')) {
                $table->integer('risk_score')->default(25)->after('risk_level');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ports', function (Blueprint $table) {
            $table->dropColumn(['port_type', 'congestion_level', 'risk_level', 'risk_score']);
        });
    }
};
