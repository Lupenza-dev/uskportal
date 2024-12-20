<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpenBalance extends Model
{
    use HasFactory,SoftDeletes;

    public $fillable =['balance','financial_year_id'];
    
    public function financial_year(){
        return $this->belongsTo(FinancialYear::class);
    }
}
