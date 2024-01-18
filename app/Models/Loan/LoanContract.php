<?php

namespace App\Models\Loan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member\Member;
use App\Models\Payment\Payment;
use Str;
use Auth;

class LoanContract extends Model
{
    use HasFactory;

    protected $fillable=['member_id','loan_application_id','loan_type_id','total_amount','total_loan_amount','installment_amount','plan',
    'fee_amount','interest_amount','interest_rate','status','outstanding_amount','contract_code','start_date','expected_end_date','created_by','uuid','disbursment_date'];

    public function member(){
        return $this->belongsTo(Member::class);
    }

    public function loan_type(){
        return $this->hasOne(LoanType::class,'id','loan_type_id');
    }

    public static function store($loan_data,$request_data){
       $loan =LoanContract::create([
        'member_id' =>$loan_data['member_id'],
        'loan_application_id' =>$loan_data['id'],
        'loan_type_id' =>$loan_data['loan_type_id'],
        'total_amount' =>$loan_data['amount'],
        'total_loan_amount' =>$loan_data['total_loan_amount'],
        'installment_amount' =>$loan_data['installment_amount'],
        'plan'               =>$loan_data['plan'],
        'fee_amount'         =>$loan_data['fee_amount'],
        'interest_amount'    =>$loan_data['interest_amount'],
        'interest_rate'      =>$loan_data['interest_rate'],
        'status'             =>"GRANTED",
        'outstanding_amount' =>$loan_data['total_loan_amount'],
        'contract_code'      =>$loan_data['loan_code'],
        'start_date'         =>processDate($request_data['payment_date']),
        'disbursment_date'   =>$request_data['payment_date'],
        'expected_end_date'  =>date('Y-m-d', strtotime("+".$loan_data["plan"]."months", strtotime(processDate($request_data['payment_date'])))),
        'uuid'               =>(string)Str::orderedUuid(),
        'created_by'         =>Auth::user()->id,
       ]);

       return $loan;
    }

    public function getStatusFormatAttribute(){
        switch ($this->status) {
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
                 $label ="<span class='badge badge-pill badge-soft-success font-size-11'>GRANTED</span>";
                break;
        }
        return $label;
    }

    public function installments(){
        return $this->hasMany(Installment::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
