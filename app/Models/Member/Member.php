<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment\Payment;
use App\Models\Loan\LoanContract;
use App\Models\Loan\LoanApplication;

class Member extends Model
{
    use HasFactory;

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function loan_contracts(){
        return $this->hasMany(LoanContract::class);
    }

    public function loan_applications(){
        return $this->hasMany(LoanApplication::class);
    }

    public function member_saving(){
        return $this->hasOne(MemberSavingSummary::class);
    }


}
