<?php

namespace Tests\Feature;

use App\Http\Controllers\MortgageLoanController;
use App\Http\Requests\CreateAmortizationLoanRequest;
use App\Models\Currency;
use App\Models\Mortgage;
use App\Models\User;
use App\Service\MortgageLoanService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AmortizationLoanTest extends TestCase
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
    public function test_amortization_loan_create(): void
    {
        $mortgage = Mortgage::first();

        // Set up the expectation for the createAmortizationLoan method
        $this->mortgageLoanServiceMock
            ->shouldReceive('createAmortizationLoan')
            ->andReturn(MortgageLoanService::class);

        $controller = new MortgageLoanController($this->mortgageLoanServiceMock);


        $res = $controller->createAmortizationLoan(new CreateAmortizationLoanRequest([
            "mortgage_loan_id"=>$mortgage->id
        ]));

        $this->assertJson($res->getContent());
    }
}
