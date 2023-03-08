<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Member\Member;
use App\Models\Member\MemberSavingSummary;
use App\Models\Payment\Payment;
use App\Http\Resources\HomepageResource;
use App\Models\Loan\LoanContract;
use Auth;

class HomeController extends Controller
{
    public function index(Request $request){
        $member =Member::with('payments','member_saving')->where('id',Auth::user()->member_id)->first();
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

    public function groupSummary(){
        $saving =MemberSavingSummary::get();
        $loans   =LoanContract::get();

        $data =[
            'total_amount' =>number_format($saving->sum('total_saving')),
            'no_of_loans'  =>$loans->count(),
            'total_loans'  =>number_format($loans->sum('total_amount')),
            'no_closed_loans' =>$loans->where('status','CLOSED')->count(),
            'closed_loans'    =>number_format($loans->where('status','CLOSED')->sum('total_amount')),
            'no_active_loans' =>$loans->where('status','GRANTED')->count(),
            'active_loans'      =>number_format($loans->where('status','GRANTED')->sum('total_amount')),
            'outstanding_loans' =>number_format($loans->where('status','GRANTED')->sum('outstanding_amount')),
        ];

        return response()->json([
            'success' =>true,
            'message' =>'Group Summary',
            'data'    =>$data
        ],200);
    }
}
