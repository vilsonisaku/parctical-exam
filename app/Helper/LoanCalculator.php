<?php

namespace App\Helper;

use App\Exceptions\LoanProcessException;
use Ramsey\Uuid\Type\Decimal;

class LoanCalculator
{
    private $loanBalance;
    private $annualTerm;
    private $annualInterestRate;

    public function __construct(float $loan_balance, int $annual_term, float $annual_interest_rate)
    {
        $this->setLoanBalance($loan_balance)
        ->setAnnualTerm($annual_term)
        ->setAnnualInterestRate($annual_interest_rate);
    }

    public function getLoanBalance(){
        return $this->loanBalance;
    }

    public function getAnualTerm(){
        return $this->annualTerm;
    }

    public function getAnualInterestRate(){
        return $this->annualInterestRate;
    }

    public function setLoanBalance(float $loan_balance)
    {
        $this->loanBalance = Helper::validateDecimal($loan_balance,"loan_amount");
        return $this;
    }

    public function setAnnualTerm(int $annual_term)
    {
        $this->annualTerm = Helper::validateDecimal($annual_term,"loan_annual_term");
        return $this;
    }

    public function setAnnualInterestRate(float $annual_interest_rate)
    {
        $this->annualInterestRate = Helper::validateDecimal($annual_interest_rate,"annual_interest_rate");
        return $this;
    }

    public function getMonthlyPayment() : float
    {
        $monthlyInterestRate = $this->getMonthlyInterestRate($this->annualInterestRate);
        $numPayments = $this->calculateMonths();
        $monthlyPayment = ($this->loanBalance * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numPayments));
        return floatval(str_replace(',', '', number_format($monthlyPayment, 2) ) );
    }



    public function calculateRemainingTerm(): int
    {
        $remainingBalance = $this->loanBalance;
        $termInMonths = $this->calculateMonths();
        $interest = $this->monthlyInterest();
        $monthlyPayment = $this->getMonthlyPayment();

        for ($month = 1; $month <= $termInMonths; $month++) {
            $principalPayment = $monthlyPayment - $interest;
            $remainingBalance -= $principalPayment;
            if ($remainingBalance <= 0) {
                return $month;
            }
        }
        return $termInMonths;
    }   

    public function calculateMonths(): int
    {
        return Helper::validateInt($this->annualTerm,"loan_annual_term") * 12;
    }

    public function monthlyInterest(): float
    {
        return $this->loanBalance * $this->getMonthlyInterestRate();
    }

    public function getMonthlyInterestRate(): float
    {
        return $this->annualInterestRate / 12 / 100;
    }
}
