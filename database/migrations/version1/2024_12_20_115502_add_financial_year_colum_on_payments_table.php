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
    public function up(): void
    {
        Schema::table('fee_past_dues', function (Blueprint $table) {
            $table->integer('financial_year_id')->default(1);
        });

        Schema::table('stock_past_due', function (Blueprint $table) {
            $table->integer('financial_year_id')->default(1);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->integer('financial_year_id')->default(1);
        });

        Schema::table('payment_requests', function (Blueprint $table) {
            $table->integer('financial_year_id')->default(1);
        });

        Schema::table('loan_applications', function (Blueprint $table) {
            $table->integer('financial_year_id')->default(1);
        });

        Schema::table('loan_contracts', function (Blueprint $table) {
            $table->integer('financial_year_id')->default(1);
        });

        Schema::table('loan_guarantors', function (Blueprint $table) {
            $table->integer('financial_year_id')->default(1);
        });

        Schema::table('payouts', function (Blueprint $table) {
            $table->integer('financial_year_id')->default(1);
        });

        Schema::table('expenditures', function (Blueprint $table) {
            $table->integer('financial_year_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fee_past_dues', function (Blueprint $table) {
            $table->dropColumn('financial_year_id');
        });

        Schema::table('stock_past_due', function (Blueprint $table) {
            $table->dropColumn('financial_year_id');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('financial_year_id');
        });

        Schema::table('payment_requests', function (Blueprint $table) {
            $table->dropColumn('financial_year_id');
        });

        Schema::table('loan_applications', function (Blueprint $table) {
            $table->dropColumn('financial_year_id');
        });

        Schema::table('loan_contracts', function (Blueprint $table) {
            $table->dropColumn('financial_year_id');
        });

        Schema::table('loan_guarantors', function (Blueprint $table) {
            $table->dropColumn('financial_year_id');
        });

        Schema::table('payouts', function (Blueprint $table) {
            $table->dropColumn('financial_year_id');
        });

        Schema::table('expenditures', function (Blueprint $table) {
            $table->dropColumn('financial_year_id');
        });
    }
};
