<?php

namespace App\Models\Loan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member\Member;
use Auth;
use Str;

class LoanApplication extends Model
{
    use HasFactory;

    protected $fillable=['member_id','amount','total_loan_amount','plan','installment_amount','fee_amount','interest_amount','interest_rate',
    'loan_type_id','loan_code','uuid','level'];

    public static function store($loan_data,$plan){
        $amount     =$loan_data['amount'];
        $plan       =$plan;
        $loan_type  =$loan_data['loan_type'];
        // $guarantors =$loan_data['guarantors'];

        if ($loan_type == 2) {
            $total_loan_amount =$amount * 1.08;
            $installment =$total_loan_amount / $plan;
            $plan =$plan;
            $interest_rate =0.8;
        } else {
            $total_loan_amount =$amount *1.10;
            $plan =1;
            $installment =$total_loan_amount;
            $interest_rate =10;
            
        }

        $member =Member::with('initiated_loan_application')->where('id',Auth::user()->member_id)->first();

        if ($member) {
            $initiated_loan =$member->initiated_loan_application;
            if ($initiated_loan) {
                $initiated_loan->level ="CANCELED";
                $initiated_loan->save();
            }
        }

        $loan =LoanApplication::create([
            'member_id'         =>Auth::user()->member_id,
            'amount'             =>$amount,
            'total_loan_amount' =>$total_loan_amount,
            'plan'              =>$plan,
            'installment_amount' =>$installment,
            'fee_amount'         =>0,
            'interest_amount'    =>$total_loan_amount - $amount,
            'interest_rate'      =>$interest_rate,
            'loan_type_id'       =>$loan_type,
            'loan_code'          =>"USKL".mt_rand(1000000,9999999),
            'uuid'               =>(string)Str::ordereduuid()
        ]);

        return $loan;
    }

    public function member(){
        return $this->hasOne(Member::class,'id','member_id');
    }

    public function active_contract(){
        return $this->hasOne(LoanContract::class,'loan_application_id','id')->where('status','GRANTED');
    }

    public function loan_type(){
        return $this->hasOne(LoanType::class,'id','loan_type_id');
    }

    public function guarantors(){
        return $this->hasMany(LoanGuarantor::class,'loan_application_id');
    }

    public function getStatusFormatAttribute(){
        switch ($this->level) {
            case 'GRANTED':
                $label ="<span class='badge badge-pill badge-soft-success font-size-11'>GRANTED</span>";
                break;
            case 'CLOSED':
                $label ="<span class='badge badge-pill badge-soft-info font-size-11'>CLOSED</span>";
                break;
            case 'CANCELED':
                $label ="<span class='badge badge-pill badge-soft-warning font-size-11'>CANCELED</span>";
                break;
            default:
                 $label ="<span class='badge badge-pill badge-soft-primary font-size-11'>Initiated</span>";
                break;
        }
        return $label;
    }

}
