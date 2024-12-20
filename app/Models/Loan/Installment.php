<?php

namespace App\Models\Loan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $fillable=['installment_no','installment_amount','current_balance','outstanding_amount','penalt_amount','past_due_days',
    'penalt_paid_amount','last_paid_amount','last_paid_date','loan_contract_id','uuid','payment_date','financial_year_id'];

    public function getStatusFormatAttribute(){
        switch ($this->status) {
            case 'OPEN':
                $label ="<span class='badge badge-pill badge-soft-success font-size-11'>OPEN</span>";
                break;
            case 'CLOSED':
                $label ="<span class='badge badge-pill badge-soft-info font-size-11'>CLOSED</span>";
                break;
            default:
                 $label ="<span class='badge badge-pill badge-soft-success font-size-11'>OPEN</span>";
                break;
        }
        return $label;
    }
}
