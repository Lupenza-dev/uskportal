<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Member\Member;
use App\Models\Payment\Payment;
use App\Http\Resources\HomepageResource;

class HomeController extends Controller
{
    public function index(Request $request){
        $validator =Validator::make(
            $request->all(), [
                'member_reg_id' =>'required',
            ]
        );

        if ($validator->fails() ) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors(),
                ], 500
            );
        }

        $valid_data =$validator->valid();
        $member =Member::where('member_reg_id',$valid_data['member_reg_id'])->first();
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
