<?php

namespace App\Models\Loan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanGuarantor extends Model
{
    use HasFactory;

    protected $fillable=['member_id','loan_application_id','status','uuid','attended_date'];
    
    public function loan(){
        return $this->belongsTo(LoanApplication::class,'loan_application_id');
    }

    public function getStatusFormatAttribute(){
        switch ($this->status) {
            case 'Approved':
                $label ="<span class='badge badge-pill badge-soft-success font-size-11'>Approved</span>";
                break;
            case 'Rejected':
                $label ="<span class='badge badge-pill badge-soft-danger font-size-11'>Rejected</span>";
                break;
            default:
                 $label ="<span class='badge badge-pill badge-soft-primary font-size-11'>Pending</span>";
                break;
        }
        return $label;
    }
    
}

