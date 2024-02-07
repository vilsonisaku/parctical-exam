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
        Schema::create('mortgage_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedDecimal('loan_balance', 8, 2);
            $table->unsignedDecimal('ending_balance', 8, 2);
            $table->unsignedDecimal('monthly_payment', 8, 2);
            $table->unsignedDecimal('annual_interest_rate', 8, 2);
            $table->unsignedInteger('annual_loan_term');
            $table->foreignId('currency_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mortgage_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mortgage_loans', function (Blueprint $table) {
            // Drop the foreign key column
            $table->dropForeign(['currency_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['mortgage_id']);
            $table->dropForeign(['loan_term_type_id']);
        });
    }
};
