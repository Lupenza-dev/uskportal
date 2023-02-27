<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LoanContractResource;
use App\Models\Member\Member;
use Auth;

class LoanController extends Controller
{
    public function loanContracts(){
        $member =Member::with('loan_contracts')->where('id',Auth::user()->member_id)->first();
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
            'message' =>'Member Loan Contracts',
            'data'    =>LoanContractResource::collection($member->loan_contracts)
        ],200);
    }
}
