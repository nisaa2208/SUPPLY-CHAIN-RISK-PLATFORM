<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Latitude dan Longitude sudah ada
        // di create_countries_table, jadi migration ini dikosongkan.
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Tidak ada yang perlu dihapus.
    }
};