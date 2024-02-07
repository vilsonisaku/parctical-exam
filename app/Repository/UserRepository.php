<?php

namespace App\Repository;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface 
{

    public function getPaidLoans(User $user) 
    {
        return $user->mortgageLoans()->whereNotNull('paid');
    }
}