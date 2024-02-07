<?php

namespace App\Trait;


trait UserTrait 
{

    public function getPaidLoans() 
    {
        return $this->loans()->whereNotNull('paid')->get();
    }

    public function getUnPaidLoans() 
    {
        return $this->loans()->whereNull('paid')->get();
    }
}