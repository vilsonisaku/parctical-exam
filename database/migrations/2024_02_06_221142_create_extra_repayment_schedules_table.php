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
        Schema::create('extra_repayment_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('month_number');
            $table->unsignedDecimal('starting_balance', 8, 2);
            $table->unsignedDecimal('monthly_payment');
            $table->unsignedDecimal('principal', 8, 2); // not including interest
            $table->unsignedDecimal('interest', 8, 2);
            $table->unsignedDecimal('extra_repayment', 8, 2);
            $table->unsignedDecimal('ending_balance', 8, 2); // total amount after payment
            
            $table->unsignedInteger('remaining_loan_term');
            
            $table->foreignId('mortgage_loan_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_repayment_schedules');
    }
};
