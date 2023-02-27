<?php

namespace App\Models\Loan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member\Member;

class LoanContract extends Model
{
    use HasFactory;

    public function member(){
        return $this->belongsTo(Member::class);
    }
}
