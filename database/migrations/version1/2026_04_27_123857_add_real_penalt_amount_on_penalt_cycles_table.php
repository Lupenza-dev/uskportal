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
        Schema::table('penalt_cycles', function (Blueprint $table) {
            $table->decimal('real_penalt_amount', 15, 2);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penalt_cycles', function (Blueprint $table) {
            $table->dropColumn('real_penalt_amount');
        });
    }
};
