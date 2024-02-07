<?php

namespace App\Service;

use App\Exceptions\LoanProcessException;
use App\Helper\Helper;
use App\Models\MortgageLoan;
use App\Trait\LoanTrait;
use Illuminate\Support\Facades\DB;

class ExtraRepaymentService 
{
    use LoanTrait;

    function __construct(){}


    function create(MortgageLoan $mortgageLoan, float $extra_amount){
        $extra_amount = Helper::validateDecimal($extra_amount,"extra_amount");

        $monthly_payment = $mortgageLoan->monthly_payment;

        $ending_balance = $mortgageLoan->ending_balance - ($monthly_payment + $extra_amount );

        $loanCalculator = $this->newLoanCalculator(
            $ending_balance,
            $mortgageLoan->annual_loan_term,
            $mortgageLoan->annual_interest_rate
        );

        $interest = $loanCalculator->monthlyInterest();

        $principal = $monthly_payment - $interest;


        DB::beginTransaction();

        try {

            $month_number = $mortgageLoan->loanAmortizations()->count() + 1;

    
            $extraRepayment = $mortgageLoan->extraRepayments()->create([
                'starting_balance'=>$mortgageLoan->ending_balance,
                'monthly_payment'=> $monthly_payment,
                'principal'=>$principal,
                'ending_balance'=>$ending_balance,
                'interest'=>$interest,
                'month_number'=>$month_number,
                'extra_repayment'=> $extra_amount,
                'remaining_loan_term'=> $loanCalculator->calculateRemainingTerm(),
            ]);
    
            if($extraRepayment){
                $mortgageLoan->update([
                    'ending_balance' => $extraRepayment->ending_balance,
                ]);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            throw new LoanProcessException("Something went wronge while saving extra repeyment into db");
        }

        DB::commit();

    }


}
