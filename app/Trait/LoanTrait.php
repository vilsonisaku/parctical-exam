<?php

namespace App\Trait;

use App\Helper\LoanCalculator;
use App\Models\MortgageLoan;
use Carbon\Carbon;

trait LoanTrait
{

    function newLoanCalculator(float $loanAmount, float $monthlyPayment, float $annualInterestRate){
        return new LoanCalculator($loanAmount,$monthlyPayment,$annualInterestRate);
    }


    /**
     * check if loan amortization is already created for current month
     */
    public function isCreatedForCurrentMonth(MortgageLoan $mortgageLoan)
    {

        return $mortgageLoan->loanAmortizations()
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
    }


}
