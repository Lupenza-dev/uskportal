<?php

namespace App\Models\Payment;

use App\Models\Loan\LoanContract;
use App\Models\Member\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    use HasFactory;

    protected $fillable =['amount','payment_date','payment_reference','member_id','payment_type','uuid','added_by','loan_contract_id','payment_for_month','getFinancialYearId'];

    public function member(){
        return $this->belongsTo(Member::class);
    }

    public function loan(){
        return $this->hasOne(LoanContract::class,'id','loan_contract_id');
    }

    public function getStatusFormatAttribute(){
        switch ($this->status) {
            case 1:
                $label ="<span class='badge badge-pill badge-soft-success font-size-11'>Approved</span>";
                break;
            case 2:
                $label ="<span class='badge badge-pill badge-soft-danger font-size-11'>Rejected</span>";
                break;
            default:
                 $label ="<span class='badge badge-pill badge-soft-warning font-size-11'>Pending</span>";
                break;
        }
        return $label;
    }

}
