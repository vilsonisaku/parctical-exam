<?php

namespace App\Http\Requests;


class CreateMortgageLoanRequest extends request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'=>'required|integer|min:1',
            'currency_id'=>'required|integer|min:1',
            'mortgage_id'=>'required|integer|min:1',
            'loan_balance'=>'required|numeric|min:1',
            'annual_interest_rate'=>'required|numeric|min:1',
            'annual_term'=>'required|integer|min:1',
        ];
    }
}
