<?php

namespace App\Service;

use App\Models\User;
use Ramsey\Uuid\Type\Decimal;

class UserService 
{

    function __construct(
        private MortgageLoanService $mortgageService,
    )
    {
        
    }

    
}
