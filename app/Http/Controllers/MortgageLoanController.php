<?php

namespace App\Http\Controllers;

use App\Exceptions\PositiveValueException;
use App\Http\Requests\CreateAmortizationLoanRequest;
use App\Http\Requests\CreateMortgageLoanRequest;
use App\Http\Requests\GetUserMortgageLoanRequest;
use App\Models\Currency;
use App\Models\Mortgage;
use App\Models\MortgageLoan;
use App\Models\User;
use App\Service\MortgageLoanService;
use Illuminate\Http\Request;

class MortgageLoanController extends Controller
{   
    function __construct(
        private MortgageLoanService $mortgageLoanService 
    )
    {}

    function view(){
        $users = User::with('mortgageLoans')->limit(10)->get();

        return view('welcome')->with(["users"=>$users]);
    }

    function get(GetUserMortgageLoanRequest $request){
        $user = User::findOrFail($request->user_id);

        $loans = $this->mortgageLoanService->getByUser($user);

        return response()->json($loans);
    }

    function createMortgageloan(CreateMortgageLoanRequest $request){
        $user = User::findOrFail($request->user_id);
        $currrency = Currency::findOrFail($request->currency_id);
        $mortgage = Mortgage::findOrFail($request->mortgage_id);

        $mortgageLoan = $this->mortgageLoanService->create($user,$currrency,$mortgage,
            $request->loan_balance,
            $request->annual_interest_rate,
            $request->annual_term,
        );


        return response()->json($mortgageLoan);
    }


    function createAmortizationLoan(CreateAmortizationLoanRequest $request){
        $mortgageLoan = MortgageLoan::findOrFail($request->mortgage_loan_id);

        $this->mortgageLoanService->createAmortizationLoan($mortgageLoan);

        $mortgageLoan->load('loanAmortizations');

        return response()->json($mortgageLoan);
    }

}
