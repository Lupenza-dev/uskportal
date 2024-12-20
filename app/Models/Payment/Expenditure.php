<?php

namespace App\Models\Payment;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    use HasFactory;

    protected $fillable =['amount','payment_date','payment_reference','remarks','uuid','created_by','paid_to_who','financial_year_id'];

    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }
}
