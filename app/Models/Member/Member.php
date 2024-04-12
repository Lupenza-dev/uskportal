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

    protected $fillable =['first_name','middle_name','last_name','phone_number','dob','member_reg_id','email','id_type_id','id_number',
    'uuid','created_by','status','member_type'];

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

    public function initiated_loan_application(){
        return $this->hasOne(LoanApplication::class)->where('level','initiated');
    }

    public function initiated_normal_loan_application(){
        return $this->hasOne(LoanApplication::class)
        ->where('level','initiated')->where('loan_type_id',2);
    }

    public function initiated_emergence_loan_application(){
        return $this->hasOne(LoanApplication::class)
        ->where('level','initiated')->where('loan_type_id',1);
    }

    public function active_normal_loan(){
        return $this->hasOne(LoanContract::class)->where('loan_type_id',2)->where('status','!=','CLOSED');
    }

    public function active_emergence_loan(){
        return $this->hasOne(LoanContract::class)->where('loan_type_id',1)->where('status','!=','CLOSED');
    }

    public function getMemberNameAttribute(){
        return ucwords($this->first_name.' '.$this->last_name);
    }

    public function stock_payments(){
        return $this->hasMany(Payment::class)
        ->where('payment_type','stock')
        ->orWhere('payment_type','stock penalty')
        ->latest();
    }

    public function fee_payments(){
        return $this->hasMany(Payment::class)
        ->where('payment_type','fee')
        ->orWhere('payment_type','fee penalty')
        ->latest();
    }

    public function id_type(){
        return $this->belongsTo(IdType::class);
    }


    public function getMemberTypesAttribute(){
        switch ($this->member_type) {
            case 1:
                $type ="Original Member";
                break;

            case 2:
                $type ="Refered Member";
                break;
            
            default:
                $type ="Original Member";
                break;

        }

        return $type;
    }

    public function member_refered(){
        return $this->hasOne(MemberReference::class,'member_id');
    }

    public function stock_dues(){
        return $this->hasMany(StockPastDue::class,'member_id');
    }

    public function fee_dues(){
        return $this->hasMany(FeePastDue::class,'member_id');
    }

}
