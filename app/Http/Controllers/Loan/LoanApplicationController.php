<?php

namespace App\Http\Controllers\Loan; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan\LoanType;
use App\Models\Loan\LoanGuarantor;
use App\Models\Loan\LoanApplication;
use Auth;
use Str;
use App\Models\Member\Member;
use App\Http\Requests\LoanApplicationRequest;
use App\Jobs\SendNotification;
use Carbon\Carbon;

class LoanApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members    =Member::whereNot('id',Auth::user()->member_id)->get();
        $loan_types =LoanType::get();
        $loans      =LoanApplication::with('member','loan_type')
                    ->whereNotIn('level',['CANCELED','GRANTED','CLOSED'])
                    ->latest()->get();
        return view('loans.loan_applications',compact('loan_types','members','loans'));
    }

    public function loanGuarantor(){
        $requests =LoanGuarantor::with('loan','loan.member')
                    ->whereHas('loan',function($query){
                        $query->where('level','!=','CANCELED');
                    })
                   ->where('member_id',Auth::user()->member_id)
                    ->get();
        return view('loans.loan_request',compact('requests'));
    }

    public function loanProfile($uuid){
        $loan =LoanApplication::where('uuid',$uuid)->first();
        return view('loans.loan_application_profile',compact('loan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoanApplicationRequest $request)
    {
        $vali_data =$request->validated();
        $plan      =$request->plan ?? 1;

        if (count($vali_data['guarantors']) != 2) {
            return response()->json([
                'success' =>false,
                'errors' =>"Two Guarantors needed To Apply Loan"
            ],500);
        }

       

        $data =LoanApplication::store($vali_data,$plan);

        if ($data['success'] == false) {
            return response()->json([
                        'success' =>false,
                        'errors' =>$data['errors']
                ],500);
        }


        foreach ($vali_data['guarantors'] as $key => $value) {
            $guarantor =LoanGuarantor::create([
                'member_id'           =>$value,
                'loan_application_id' =>$data['loan_id'],
                'uuid'                =>(string)Str::orderedUuid()
            ]);

            SendNotification::dispatch($guarantor,4)->onQueue('emails');

        }

        // if member refered
        if (Auth::user()->member?->member_type == 2) {
            $guarantor =LoanGuarantor::create([
                'member_id'           =>Auth::user()->member?->member_refered?->refer_member_id,
                'loan_application_id' =>$data['loan_id'],
                'uuid'                =>(string)Str::orderedUuid()
            ]);

            SendNotification::dispatch($guarantor,4)->onQueue('emails');
        }

        return response()->json([
            'success' =>true,
            'message' =>"You have successfully applied loan , wait for approval"
        ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function loanRequest(Request $request){
        $action =$request->action;
        $uuid =$request->uuid;

        $loan_ =LoanGuarantor::where('uuid',$uuid)->update([
            'status'        =>($action == "approve") ? "Approved" : "Rejected",
            'attended_date' =>Carbon::now(),
            'comment'       =>$request->comment ?? null,
        ]);

        $loan =LoanGuarantor::where('uuid',$uuid)->first();
        if ($action == "approve") {
              SendNotification::dispatch($loan,5)->onQueue('emails');
        } else {
              SendNotification::dispatch($loan,6)->onQueue('emails');
        }
        

        return response()->json([
            'success' =>true,
            'message' =>"Action Done Successfully"
        ],200);
    }
}
