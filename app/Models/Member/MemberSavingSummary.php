<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSavingSummary extends Model
{
    use HasFactory;

    protected $fillable=['member_id','stock','current_stock','holded_stock',
    'last_stock_amount','last_purchase_date','fees','uuid','fee_for_month',
    'last_fee_amount','last_fee_purchase_date','stock_for_month','past_due_days','stock_penalty'];

    public function member(){
        return $this->belongsTo(Member::class,'member_id');
    }

    public function overDueStock(){
        return $this->hasMany(StockPastDue::class,'member_id','member_id')->where('paid_status',0);
    }

    public function dueStock(){
        return $this->hasMany(StockPastDue::class,'member_id','member_id');
    }

    public function overDueFee(){
        return $this->hasMany(FeePastDue::class,'member_id','member_id')->where('paid_status',0);
    }

    public function dueFees(){
        return $this->hasMany(FeePastDue::class,'member_id','member_id');
    }

}
