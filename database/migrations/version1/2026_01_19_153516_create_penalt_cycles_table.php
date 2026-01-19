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
        Schema::create('penalt_cycles', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('installment_id');
            $table->unsignedBigInteger('loan_contract_id');
    
            $table->decimal('penalt_amount', 15, 2);
            $table->decimal('penalt_amount_paid', 15, 2);
            $table->decimal('past_due_amount', 15, 2);
            $table->decimal('installment_amount', 15, 2);
            $table->decimal('installment_penalted', 15, 2);
            $table->string('penalt_month');
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
        Schema::dropIfExists('penalt_cycles');
    }
};
