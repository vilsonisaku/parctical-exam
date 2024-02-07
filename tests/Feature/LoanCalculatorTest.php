<?php

namespace Tests\Feature;

use App\Exceptions\PositiveValueException;
use App\Helper\LoanCalculator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanCalculatorTest extends TestCase
{

    protected $loanCalculator;

    protected function setUp(): void
    {
        parent::setUp();

        $loan_balance = 200000;
        $annual_loan_term = 10;
        $annual_interest_rate = 6;

        $this->loanCalculator = new LoanCalculator($loan_balance,$annual_loan_term,$annual_interest_rate);

    }

    /**
     * A basic feature test example.
     */
    public function test_negative_loan_balance(): void
    {
        $this->expectException(PositiveValueException::class);
        new LoanCalculator(-200000,10,6);
    }

    /**
     * A basic feature test example.
     */
    public function test_negative_annual_loan_term(): void
    {
        $this->expectException(PositiveValueException::class);
        new LoanCalculator(200000,-10,6);
    }

    /**
     * A basic feature test example.
     */
    public function test_negative_annual_interest_rate(): void
    {
        $this->expectException(PositiveValueException::class);
        new LoanCalculator(200000,10,-6);
    }

    /**
     * A basic feature test example.
     */
    public function test_caculate_monthly_payment(): void
    {
        $monthlyPayment = $this->loanCalculator->getMonthlyPayment();
        $this->assertEquals($monthlyPayment,2220.41);
    }


    /**
     * A basic feature test example.
     */
    public function test_caculate_months_of_years(): void
    {
        $months = $this->loanCalculator->calculateMonths();
        $this->assertEquals($months,120);
    }


    /**
     * A basic feature test example.
     */
    public function test_caculate_monthly_interest(): void
    {
        $interest = $this->loanCalculator->monthlyInterest();
        $this->assertEquals($interest,1000);
    }

    /**
     * A basic feature test example.
     */
    public function test_caculate_monthly_interest_rate(): void
    {
        $interestRate = $this->loanCalculator->getMonthlyInterestRate();
        $this->assertEquals($interestRate,0.005);
    }

    /**
     * A basic feature test example.
     */
    public function test_caculate_remaining_term(): void
    {
        $remainingTerm = $this->loanCalculator->calculateRemainingTerm();
        $this->assertEquals($remainingTerm,120);
    }
}
