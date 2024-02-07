<?php

namespace App\Service;

use App\Exceptions\LoanProcessException;
use App\Models\LoanAmortizationSchedule;
use App\Models\MortgageLoan;
use App\Trait\LoanTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanAmortizationService 
{
    use LoanTrait;

    function __construct(){}


    function create(MortgageLoan $mortgageLoan){
        if($this->isCreatedForCurrentMonth($mortgageLoan)){
            throw new LoanProcessException(__("exceptions.loan_amortization_already_created"),409);
        }
        if($mortgageLoan->loanAmortizations()->whereNull('paid')->count()){
            throw new LoanProcessException("You have unpaid loans, please pay it");
        }

        $monthly_payment = $mortgageLoan->monthly_payment;

        $loanCalc = $this->newLoanCalculator(
            $mortgageLoan->ending_balance,
            $mortgageLoan->annual_loan_term,
            $mortgageLoan->annual_interest_rate
        );

        $interest = $loanCalc->monthlyInterest();

        $principal = $monthly_payment - $interest;

        $month_number = $mortgageLoan->loanAmortizations()->count() + 1;

        return $mortgageLoan->loanAmortizations()->create([
            'starting_balance'=>$mortgageLoan->ending_balance,
            'monthly_payment'=> $monthly_payment,
            'principal'=>$principal,
            'ending_balance'=>$mortgageLoan->ending_balance - $principal,
            'interest'=>$interest,
            'month_number'=>$month_number,
        ]);
    }

    /**
     * 
     */
    function makePaid(LoanAmortizationSchedule $loan){

        DB::beginTransaction();

        try {
            $loan->update([
                "paid" => Carbon::now()
            ]);
            $mortgageLoan = $loan->mortgageLoan()->first();
    
            $mortgageLoan->update([
                "ending_balance"=> $mortgageLoan->ending_balance - $loan->principal
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            throw new LoanProcessException("Something went wrong while saving on load amortization into db");
        }

        DB::commit();
    }
}
