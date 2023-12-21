<?php

namespace App\Models\Payment;

use App\Models\Loan\LoanContract;
use App\Models\Member\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
use Auth;

class Payout extends Model
{
    use HasFactory;
    protected $fillable=['amount','payment_reference','payment_date','bank_account_no','created_by','member_id','loan_contract_id','uuid'];
    public static function store($payment,$loan){
        $payout =Payout::create([
            'amount' =>$payment['amount'],
            'payment_reference' =>$payment['payment_reference'],
            'payment_date'      =>$payment['payment_date'],
            'bank_account_no'   =>$payment['bank_account_no'],
            'created_by'  =>Auth::user()->id,
            'uuid'        =>(string)Str::orderedUuid(),
            'member_id'        =>$loan['member_id'],
            'loan_contract_id' =>$loan['id']
        ]);
    }

    public function member(){
        return $this->belongsTo(Member::class);
    }

    public function loan(){
        return $this->hasOne(LoanContract::class,'id','loan_contract_id');
    }
}
