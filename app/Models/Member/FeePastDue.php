<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePastDue extends Model
{
    use HasFactory;

    protected $fillable =['member_id','fee_for_month','past_due_days','uuid','penalty'];

    public function getPaidStatusFormatAttribute(){
        switch ($this->paid_status) {
            case 1:
                $label ="<span class='badge badge-pill badge-soft-success font-size-11'>Paid</span>";
                break;
            default:
                 $label ="<span class='badge badge-pill badge-soft-warning font-size-11'>Not Paid</span>";
                break;
        }
        return $label;
    }

}
