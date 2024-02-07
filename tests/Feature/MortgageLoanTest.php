<?php

namespace Tests\Feature;

use App\Http\Controllers\MortgageLoanController;
use App\Http\Requests\CreateMortgageLoanRequest;
use App\Models\Currency;
use App\Models\Mortgage;
use App\Models\MortgageLoan;
use App\Models\User;
use App\Service\MortgageLoanService;
use Tests\TestCase;

class MortgageLoanTest extends TestCase
{
    protected $mortgageLoanServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock instance for MortgageLoanService
        $this->mortgageLoanServiceMock = $this->mock(MortgageLoanService::class);
    }

    /**
     * A basic unit test example.
     */
    public function test_controller_mortage_loan_create(): void
    {
        $user = User::factory()->create();

        $currency = Currency::first();
        $mortgage = Mortgage::first();

        // Set up the expectation for the createAmortizationLoan method
        $this->mortgageLoanServiceMock
            ->shouldReceive('create')
            ->andReturn(MortgageLoanService::class);

        $controller = new MortgageLoanController($this->mortgageLoanServiceMock);

        // $this->expectException(LoanProcessException::class);
        // $this->expectException(HttpResponseException::class);

        $res = $controller->createMortgageloan(new CreateMortgageLoanRequest([
            "user_id"=>$user->id,
            "currency_id"=>$currency->id,
            "mortgage_id"=>$mortgage->id,
            "loan_balance"=>1000,
            "annual_interest_rate"=>6,
            "annual_term"=>10,
        ]));

        $this->assertJson($res->getContent());
        // $created = $this->mortgageLoanServiceMock->create($user,$currency,$mortgage,200000,6,10);

    }


        /**
     * A basic unit test example.
     */
    public function test_service_mortage_loan_create(): void
    {
        $user = User::factory()->create();
        $currency = Currency::first();
        $mortgage = Mortgage::first();
        $loanAmount = 200000;
        $loanTermInYears = 10;
        $annualInterestRate = 6;

        // Set up the expectation for the create method
        $this->mortgageLoanServiceMock
            ->shouldReceive('create')
            ->with($user, $currency, $mortgage, $loanAmount, $loanTermInYears, $annualInterestRate)
            ->andReturn(new MortgageLoan);

        // Call the method under test
        $created = $this->mortgageLoanServiceMock->create($user, $currency, $mortgage, $loanAmount, $loanTermInYears, $annualInterestRate);

        // Assert that the returned value is an object of MortgageLoan class
        $this->assertInstanceOf(MortgageLoan::class, $created);

    }
}
