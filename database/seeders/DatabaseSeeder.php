<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Helper\PositiveFloatValue;
use App\Models\Currency;
use App\Models\LoanTermType;
use App\Models\Mortgage;
use App\Models\MortgageLoan;
use App\Models\User;
use App\Service\ExtraRepaymentService;
use App\Service\LoanAmortizationService;
use App\Service\MortgageLoanService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Type\Decimal;

class DatabaseSeeder extends Seeder
{
    function __construct(
        private MortgageLoanService $mortgageLoanService
    )
    {
        
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $currency = Currency::create(['name'=>'Euro']);

        $mortgage = Mortgage::create(['name'=>'General']);

        $user = User::first();

        $this->mortgageLoanService->create($user,$currency,$mortgage,25000,8.5,2);

        $mortgageLoan = MortgageLoan::first();

        $this->mortgageLoanService
        ->createAmortizationLoan($mortgageLoan)
        ->createExtraRepayment($mortgageLoan, 1000);
    }
}
