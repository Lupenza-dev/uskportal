<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockPastDue extends Model
{
    use HasFactory;

    protected $table ='stock_past_due';

    protected $fillable =['member_id','stock_for_month','past_due_days','uuid','penalty'];
}
