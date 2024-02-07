<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraRepaymentSchedule extends Model
{
    use HasFactory;

    public function mortgageLoan(){
        return $this->belongsTo(MortgageLoan::class);
    }
}
