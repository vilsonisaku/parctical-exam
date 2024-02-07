<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Mortgage;
use App\Models\MortgageLoan;
use App\Models\User;
use App\Service\MortgageLoanService;
use Illuminate\Database\Seeder;

class MortgageLoanSeeder extends Seeder
{

    function __construct(
        private MortgageLoanService $mortgageLoanService
    )
    {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currency = Currency::first();
        $mortgage = Mortgage::first();
        $users = User::all();
        foreach ($users as $user) {
            MortgageLoan::factory(2)->create([
                "user_id" => $user->id,
                "currency_id" => $currency->id,
                "mortgage_id" => $mortgage->id,
            ]);

            foreach($user->mortgageLoans as $mortgageLoan){
                $this->mortgageLoanService
                ->createAmortizationLoan($mortgageLoan)
                ->createExtraRepayment($mortgageLoan, 1000 );
            }

        }
    }
}
