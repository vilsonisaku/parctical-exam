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
        Schema::create('loan_amortization_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedDecimal('starting_balance', 8, 2);
            $table->unsignedDecimal('principal', 8, 2);
            $table->unsignedDecimal('ending_balance', 8, 2);
            $table->unsignedDecimal('interest', 8, 2);
            $table->unsignedDecimal('monthly_payment');

            $table->unsignedInteger('month_number');
            $table->timestamp('paid')->nullable();

            $table->foreignId('mortgage_loan_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_amortization_schedules');
    }
};
