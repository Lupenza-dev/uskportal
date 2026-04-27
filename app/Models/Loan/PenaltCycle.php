<?php

namespace App\Models\Loan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltCycle extends Model
{
    use HasFactory;

    protected $fillable =[
        'installment_id','penalt_amount','penalt_amount_paid','past_due_amount','penalt_month','installment_amount','installment_penalted','loan_contract_id','real_penalt_amount'
    ];

    public function installment(){
        return $this->hasOne(Installment::class,'id','installment_id');
    }

    
}
