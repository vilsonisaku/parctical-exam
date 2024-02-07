<?php

namespace App\Http\Requests;


class GetUserMortgageLoanRequest extends Request
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
        ];
    }
}
