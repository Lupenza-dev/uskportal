<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberReference extends Model
{
    use HasFactory;

    protected $fillable =['refer_member_id','member_id','uuid'];

    public function member(){
        return $this->belongsTo(Member::class,'refer_member_id');
    }
}
