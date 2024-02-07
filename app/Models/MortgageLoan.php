<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MortgageLoan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'loan_balance',
        'ending_balance',
        'annual_interest_rate',
        'annual_loan_term',
        'monthly_payment'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function mortgage(){
        return $this->belongsTo(Mortgage::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }


    public function loanAmortizations(){
        return $this->hasMany(LoanAmortizationSchedule::class);
    }

    public function extraRepayments(){
        return $this->hasMany(ExtraRepaymentSchedule::class);
    }
}
