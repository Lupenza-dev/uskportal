<?php

namespace App\Models\Payment;

use App\Models\Loan\LoanContract;
use App\Models\Member\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable=['member_id','amount','payment_reference','payment_date','added_by','uuid','loan_contract_id','payment_for_month','payment_type'];

    public function member(){
        return $this->belongsTo(Member::class);
    }

    public function loan(){
        return $this->hasOne(LoanContract::class,'id','loan_contract_id');
    }

}
