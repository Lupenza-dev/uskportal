<?php

namespace App\Http\Controllers\Payment;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Traits\PaymentTrait;
use App\Models\Loan\LoanContract;
use App\Models\Payment\Payment;
use App\Models\Payment\PaymentRequest;
use App\Models\Payment\Payout;
use Illuminate\Http\Request;
use Str;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    use PaymentTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $payments =Payment::latest()->get();
        return view('payments.all_payment',compact('payments'));
    }

    public function paymentDisbursed()
    {   
        $payments =Payout::with('member','loan')->latest()->get();
        return view('payments.all_payment_disbursed',compact('payments'));
    }

    public function pendingPayments()
    {   
        $payments =PaymentRequest::with('member','loan')->where('status',0)->orWhere('status',2)->latest()->get();
        return view('payments.all_payment_request',compact('payments'));
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
    public function store(Request $request)
    {
        //
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

    public function paymentRequest(Request $request){
        $valid =$this->validate($request,[
            'amount'            =>'required',
            'payment_reference' =>'required','unique:payment_requests,payment_reference','unique:payments,payment_reference',
            'payment_date'      =>'required',
        ]);

        $payment =PaymentRequest::create([
            'amount'            =>$valid['amount'],
            'payment_reference' =>$valid['payment_reference'],
            'payment_date'      =>$valid['payment_date'],
            'loan_contract_id'  =>$request->loan_id ?? null,
            'member_id'         =>$request->member_id ?? null,
            'payment_type'      =>$request->payment_type ?? null,
            'payment_for_month' =>$request->payment_for_month ?? null,
            'uuid'              =>(string)Str::orderedUuid(),
            'added_by'          =>Auth::user()->id
        ]);

        return response()->json([
            'success' =>true,
            'message' =>"Payment Addedd , Wait for Approval Payment to effect the Loan",
        ],200);

    }

    public function approvePayment(Request $request){
        
        $id =$request->id;

        try {

        DB::transaction(function() use ($id ){
            // case 1 loan repayment
             $payment_request =PaymentRequest::find($id);

             $check_payment =Payment::where('payment_reference',$payment_request->payment_reference)
                           // ->where('member_id','!=',null)
                            ->first();

            if ($check_payment) {
                throw new GeneralException('Payment Already Exist');
            }

            $payment =Payment::where('payment_reference',$payment_request->payment_reference)->first();
            if (!$payment) {
                $payment =Payment::create([
                    'member_id'       =>$payment_request->member_id,
                    'amount'          =>$payment_request->amount,
                    'payment_reference'       =>$payment_request->payment_reference,
                   // 'payment_method'       =>$valid_data['payment_method'],
                   // 'payment_channel'       =>$valid_data['payment_channel'],
                    'payment_date'          =>$payment_request->payment_date,
                    'payment_type'          =>$payment_request->payment_type,
                    'payment_for_month'     =>$payment_request->payment_for_month,
                    'added_by'              =>Auth::user()->id,
                    'uuid'                  =>(string)Str::orderedUuid(),
                    'loan_contract_id'      =>$payment_request->loan_contract_id,
                ]);
            }
            if ($payment_request->payment_type == "loan") {
                    Log::info('tunaingia');
               $data =$this->updateInstallment($payment);

                $payment_request->status =1;
                $payment_request->approved_by =Auth::user()->id;
                $payment_request->save();
                
            }

            if ($payment_request->payment_type == "stock") {
                $this->updateStock($payment);

                $payment_request->status =1;
                $payment_request->approved_by =Auth::user()->id;
                $payment_request->save();
            }

            if ($payment_request->payment_type == "fee") {
                $this->updateFee($payment);

                $payment_request->status =1;
                $payment_request->approved_by =Auth::user()->id;
                $payment_request->save();
            }

            //return true;
        });

             //code...
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);

            // Return an error response to the view
            return response()->json([
                'success' => false,
                'errors' => $th->getMessage(), // You can customize the error message here
            ], 500);
        }

        return response()->json([
            'success' =>true,
            'message' =>'Action Done Successfully',
        ],200);

    }
}
