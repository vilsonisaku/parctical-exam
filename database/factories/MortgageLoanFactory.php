<?php

namespace Database\Factories;

use App\Helper\LoanCalculator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MortgageLoan>
 */
class MortgageLoanFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $loan_balance = fake()->numberBetween(1000, 100000);
        $annual_interest_rate = fake()->randomFloat(2, 1, 10);
        $annual_loan_term = fake()->numberBetween(1, 30);
        $loanCalc = new LoanCalculator($loan_balance,$annual_loan_term,$annual_interest_rate);
        return [
            'loan_balance' => $loan_balance,
            'ending_balance' => $loan_balance,
            'annual_interest_rate' => $annual_interest_rate,
            'annual_loan_term' => $annual_loan_term,
            'monthly_payment' => $loanCalc->getMonthlyPayment(),
        ];
    }
}
