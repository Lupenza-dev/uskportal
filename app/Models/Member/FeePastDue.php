<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePastDue extends Model
{
    use HasFactory;

    protected $fillable =['member_id','fee_for_month','past_due_days','uuid','penalty'];

}
