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
        $loans      =LoanApplication::with('member','loan_type')->whereNot('level','CANCELED')->latest()->get();
        return view('loans.loan_applications',compact('loan_types','members','loans'));
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
       

        $loan_application =LoanApplication::store($vali_data);

        foreach ($vali_data['guarantors'] as $key => $value) {
            $guarantor =LoanGuarantor::create([
                'member_id'           =>$value,
                'loan_application_id' =>$loan_application->id,
                'uuid'                =>(string)Str::orderedUuid()
            ]);
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
}
