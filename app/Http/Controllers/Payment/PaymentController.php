<?php

namespace App\Http\Controllers\Payment;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Traits\PaymentTrait;
use App\Jobs\SendNotification;
use App\Models\Loan\LoanContract;
use App\Models\Payment\Expenditure;
use App\Models\Payment\Payment;
use App\Models\Payment\PaymentRequest;
use App\Models\Payment\Payout;
use Illuminate\Http\Request;
use Str;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
        $valid = $this->validate($request, [
            'amount' => 'required',
            'payment_reference' => [
                'required',
                Rule::unique('payment_requests', 'payment_reference'),
                Rule::unique('payments', 'payment_reference')
            ],
            'payment_date' => 'required',
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

        SendNotification::dispatch($payment,1)->onQueue('emails');

        return response()->json([
            'success' =>true,
            'message' =>"Payment Addedd , Wait for Approval Payment to effect",
        ],200);

    }

    public function approvePayment(Request $request){
        
        $id =$request->id;

        $payment_request =PaymentRequest::find($id);

        $check_payment =Payment::where('payment_reference',$payment_request->payment_reference)
                      // ->where('member_id','!=',null)
                       ->first();
        
        if ($payment_request->status != 0) {
            return response()->json([
                'success' =>false,
                'errors' =>'Action was already Done On This Request',
            ],500);
        }

       if ($check_payment) {
           $payment_request->comment ="Payment Already Exist";
           $payment_request->attended_date =Carbon::now();
           $payment_request->approved_by =Auth::user()->id;
           $payment_request->status =2;
           $payment_request->save();

           return response()->json([
            'success' =>false,
            'errors' =>'Payment Already Exist',
        ],500);
       }

        try {

        DB::transaction(function() use ($payment_request ){
            // case 1 loan repayment
            

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

            if ($payment_request->payment_type == "stock penalty") {
                $this->updateStockPenalty($payment);

                $payment_request->status =1;
                $payment_request->approved_by =Auth::user()->id;
                $payment_request->save();
            }

            if ($payment_request->payment_type == "fee penalty") {
                $this->updateFeePenalty($payment);

                $payment_request->status =1;
                $payment_request->approved_by =Auth::user()->id;
                $payment_request->save();
            }
            Log::info('Tunaenda kutuma email');
            SendNotification::dispatch($payment,2)->onQueue('emails');

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

    public function rejectPayment(Request $request){
        $id      =$request->uuid;
        $comment =$request->comment;

        $payment_request =PaymentRequest::find($id);

        if ($payment_request->status != 0) {
            return response()->json([
                'success' =>false,
                'errors' =>'Action was already Done On This Request',
            ],500);
        }

        $payment_request->status =2;
        $payment_request->comment =$comment;
        $payment_request->attended_date =Carbon::now();
        $payment_request->approved_by =Auth::user()->id;
        $payment_request->save();

        Log::info('Tunaenda kutuma rejection email');
        SendNotification::dispatch($payment_request,3)->onQueue('emails');

        return response()->json([
            'success' =>true,
            'message' =>'Action Done Successfully',
        ],200);
    }

    public function expenditureForm(){
        $payments =Expenditure::with('user')->latest()->get();
        return view('payments.expenditures',compact('payments'));
    }

    public function storeExpenditure(Request $request){
        $valid = $this->validate($request, [
            'amount' => 'required',
            'payment_reference' => [
                'required',
                Rule::unique('expenditures', 'payment_reference')
            ],
            'paid_to_who' => 'required',
            'payment_date' => 'required',
            'remarks' => 'required',
        ]);

        $data = Expenditure::create(array_merge($valid, [
            'created_by' => Auth::id(),
            'uuid'       => (string) Str::orderedUuid(),
        ]));
        

        return response()->json([
            'success' =>true,
            'message' =>'Action Done Successfully',
        ],200);
    }

}
