<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Trait\UserTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function mortgageLoans(){
        return $this->hasMany(MortgageLoan::class);
    }

    public function loanAmortizations(){
        return $this->hasManyThrough(LoanAmortizationSchedule::class,MortgageLoan::class,'id','mortgage_loan_id');
    }

    public function extraRepayments(){
        return $this->hasManyThrough(ExtraRepaymentSchedule::class,MortgageLoan::class,'id','mortgage_loan_id');
    }
}
