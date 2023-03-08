<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member\Member;
use App\Models\Payment\Payment;
use App\Http\Resources\PaymentResource;
use Auth; 

class PaymentController extends Controller
{
    public function index(Request $request){
        $member =Member::with('payments')->where('id',Auth::user()->member_id)->first();
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
            'message' =>'Member Payments',
            'data'    =>PaymentResource::collection($member->payments)
        ],200);
    }

    public function allPayments(){
        $payments =Payment::latest()->get();
        return response()->json([
            'success' =>true,
            'message' =>'Member Payments',
            'data'    =>PaymentResource::collection($payments)
        ],200);

    }
}
