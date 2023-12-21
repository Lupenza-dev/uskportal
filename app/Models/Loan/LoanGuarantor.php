<?php

namespace App\Models\Loan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanGuarantor extends Model
{
    use HasFactory;

    protected $fillable=['member_id','loan_application_id','status','uuid','attended_date'];
}
