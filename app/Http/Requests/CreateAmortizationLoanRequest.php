<?php

namespace App\Http\Requests;


class CreateAmortizationLoanRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mortgage_loan_id'=>'required|integer|min:1'
        ];
    }
}
