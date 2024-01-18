<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoanStoreRequest;
use App\Models\Loan\LoanApplication;
use App\Models\Loan\LoanContract;
use App\Models\Loan\LoanGuarantor;
use App\Models\Payment\Payout;
use Illuminate\Support\Facades\Log;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans =LoanContract::with('member','loan_type')->latest('start_date')->get();
        return view('loans.granted_loans',compact('loans'));
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
    public function store(LoanStoreRequest $request)
    {
        $request_data = $request->validated();
        $loan_application =LoanApplication::where('uuid',$request_data['uuid'])->first();
       
        if ($loan_application->guarantors()->where('status','!=','Approved')->count()) {
            return response()->json([
                'success' =>false,
                'errors' =>"Loan Application not approved or rejected by Guarantor",
            ],500);
        }

        if ($loan_application->active_contract) {
            return response()->json([
                'success' =>false,
                'errors' =>"This Application has already approved and has active loan",
            ],500);
        }

        if ($loan_application->amount != $request_data['amount']) {
            return response()->json([
                'success' =>false,
                'errors' =>"Amount Applied vs amount disbursed not equal",
            ],500);
        }


        $loan =LoanContract::store($loan_application,$request_data);

        $payout =Payout::store($request_data,$loan);
        
        return response()->json([
            'success' =>true,
            'message' =>'Loan Created Successfully',
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $loan =LoanContract::where('uuid',$uuid)->first();
        return view('loans.loan_profile',compact('loan'));
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
}
