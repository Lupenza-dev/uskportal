<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment\Payment;

class Member extends Model
{
    use HasFactory;

    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
