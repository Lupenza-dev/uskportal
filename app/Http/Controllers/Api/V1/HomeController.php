<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Member\Member;
use App\Models\Payment\Payment;
use App\Http\Resources\HomepageResource;
use Auth;

class HomeController extends Controller
{
    public function index(Request $request){
        $member =Member::where('id',Auth::user()->member_id)->first();
        if (!$member) {
            return response()->json(
                [
                    'success' => false,
                    'message' =>"Member not found !!!!!!!!!!!",
                ], 500
            );
        }

        return response()->json([
            'success' =>true,
            'message' =>'Member exist',
            'data'    =>new HomepageResource($member)
        ],200);
    }
}
