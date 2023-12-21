<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSavingSummary extends Model
{
    use HasFactory;

    protected $fillable=['member_id','stock','current_stock','holded_stock','last_stock_amount','last_purchase_date','fees','uuid'];
}
