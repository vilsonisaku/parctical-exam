<?php

namespace App\Service;

use App\Exceptions\LoanProcessException;
use App\Helper\PositiveFloatValue;
use App\Models\Currency;
use App\Models\LoanTermType;
use App\Models\Mortgage;
use App\Models\MortgageLoan;
use App\Models\User;
use App\Trait\LoanTrait;
use Exception;
use Ramsey\Uuid\Type\Decimal;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MortgageLoanService 
{
    use LoanTrait;

    function __construct(
        private LoanAmortizationService $loanAmortizationService,
        private ExtraRepaymentService $extraRepaymentService,
    ){}

    function createAmortizationLoan(MortgageLoan $mortgageLoan){
        $this->loanAmortizationService->create($mortgageLoan);
        return $this;
    }

    function createExtraRepayment(MortgageLoan $mortgageLoan,float $extra_amount){
        $this->extraRepaymentService->create($mortgageLoan,$extra_amount);
        return $this;
    }


    function getByUser(User $user){
        return $user->mortgageLoans()->with('loanAmortizations','extraRepayments')->get();
    }

    /**
     * create user loan for specific mortgage
     */
    function create(User $user,Currency $currency,Mortgage $mortgage, float $loan_balance, float $annual_interest_rate, int $annual_term ){

        $loanCalc = $this->newLoanCalculator($loan_balance,$annual_term,$annual_interest_rate);

        $monthly_payment = $loanCalc->getMonthlyPayment();

        $mortgageLoan = $user->mortgageLoans()->make([
            'loan_balance'=>$loanCalc->getLoanBalance(),
            'ending_balance'=>$loanCalc->getLoanBalance(),
            'annual_interest_rate'=>$loanCalc->getAnualInterestRate(),
            'annual_loan_term'=>$loanCalc->getAnualTerm(),
            'monthly_payment'=>$monthly_payment,
        ]);
        $mortgageLoan->currency()->associate($currency)
        ->mortgage()->associate($mortgage)
        ->save();

        return $mortgageLoan;
    }
    
}
