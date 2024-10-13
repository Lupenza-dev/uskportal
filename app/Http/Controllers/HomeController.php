<?php

namespace App\Http\Controllers;

use App\Jobs\FeePastDueCalculation;
use App\Jobs\StockPastDueCalculation;
use App\Jobs\LoanPenaltCalculation;
use App\Models\Loan\Installment;
use App\Models\Loan\LoanContract;
use App\Models\Member\FeePastDue;
use App\Models\Member\Member;
use App\Models\Member\MemberSavingSummary;
use App\Models\Member\StockPastDue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function testJobs(){
       // return $this->loanPenalty();
        LoanPenaltCalculation::dispatch();
       // StockPastDueCalculation::dispatch();
       // FeePastDueCalculation::dispatch();
        return true;
    }

    public function calculatePastDueOnStock(){
       
        $members =MemberSavingSummary::where('stock_for_month','!=',date('F Y'))->get();
        if ($members->count() > 0) {

            foreach ($members as $member) {
                 // If no stock purchase found, calculate past due days
                $currentDate = Carbon::now();
                $lastPurchaseDate = Carbon::parse($member->stock_for_month ?? "2023-12-01")->endOfMonth();
        
                if ($currentDate->greaterThan($lastPurchaseDate)) {
                    // Check if the next month after the purchase date has passed
                    $nextMonthAfterPurchase = $lastPurchaseDate->copy()->addMonth();
                    if ($currentDate->greaterThanOrEqualTo($nextMonthAfterPurchase->endOfMonth())) {
                        // Calculate past due days
                        $pastDueDays = $currentDate->diffInDays($nextMonthAfterPurchase->endOfMonth());
                        $member->past_due_days =$pastDueDays;
                        $member->stock_penalty =$pastDueDays * 1500;
                        $member->save();
                        
                        $stock =StockPastDue::updateOrCreate([
                            'member_id' =>$member->member_id,
                            'stock_for_month' =>$nextMonthAfterPurchase->endOfMonth()->format('F Y'),
                        ],[
                            'past_due_days' =>$pastDueDays,
                            'penalty'       =>$pastDueDays * 1500,
                            'uuid'          =>Str::orderedUuid(),
                        ]);
                        
                      
                    }
                }
            }
           
           
        }

        return true;
    }

    public function calculatePastDueOnFee(){
        $members =MemberSavingSummary::with('member')
        ->where('fee_for_month','!=',date('F Y'))
        ->orWhere('fees',null)
       // ->where('member_id',13)
      //  ->orWhere('fee_for_month',null)
        ->get();
       // $members =MemberSavingSummary::where('stock',0)->get();
        if ($members->count() > 0) {

            foreach ($members as $member) {
                 // If no stock purchase found, calculate past due days
                $currentDate = Carbon::now();
                
                $lastPurchaseDate = Carbon::parse($member->fee_for_month ?? "2023-12-01")->endOfMonth();
        
                if ($currentDate->greaterThan($lastPurchaseDate) ) {
                    // Check if the next month after the purchase date has passed
                    $nextMonthAfterPurchase = $lastPurchaseDate->copy()->addMonth();
                    if ($currentDate->greaterThanOrEqualTo($nextMonthAfterPurchase->endOfMonth())) {
                        // Calculate past due days
                        $pastDueDays = $currentDate->diffInDays($nextMonthAfterPurchase->endOfMonth());
                        $member->fee_past_due_days =$pastDueDays;
                        $member->fee_penalty =$pastDueDays * 1500;
                        $member->save();
                        
                        $stock =FeePastDue::updateOrCreate([
                            'member_id' =>$member->member_id,
                            'fee_for_month' =>$nextMonthAfterPurchase->endOfMonth()->format('F Y'),
                        ],[
                            'past_due_days' =>$pastDueDays,
                            'penalty'       =>$pastDueDays * 1500,
                            'uuid'          =>Str::orderedUuid(),
                        ]);
                        
                      
                    }
                }
            }
           
        }
        

    return true;

    }

    public function loanPenalty(){
        $installments =Installment::where('status','OPEN')
                        ->where('payment_date','<',Carbon::now())
                        ->get();

        foreach ($installments as $installment) {
            $past_due_days =Carbon::now()->diffInDays($installment->payment_date);
            
            if ($installment->penalt_amount != 0 or $installment->penalt_amount_paid > 0) {
                $penalt_amount =$installment->penalt_amount;
            }else{
                $penalt_amount =0.05 * $installment->installment_amount;
            }

            $installment->past_due_days   =$past_due_days;
            $installment->penalt_amount   =$penalt_amount;
            $installment->past_due_amount =$penalt_amount + $installment->installment_amount;
            $installment->save();

            $contract =LoanContract::with('installments')->where('id',$installment->loan_contract_id)->first();
            $high_due_inst =Installment::where('loan_contract_id',$installment->loan_contract_id)
                            ->where('outstanding_amount','>',0)
                            ->orderby('id','DESC')
                            ->first();
 
            $cont_due_day = $high_due_inst->past_due_days;

            if($contract->highest_past_due_days >= $cont_due_day){
                $highest_past_due_days = $contract->highest_past_due_days;
             }else{
                $highest_past_due_days = $cont_due_day;
             }

            $contract->penalt_amount         = $contract->installments->sum('penalt_amount');
            $contract->past_due_amount       = $contract->installments->sum('past_due_amount');
            $contract->past_due_days         = $cont_due_day;
            $contract->highest_past_due_days = $highest_past_due_days;
            $contract->save();



        }
        return true;
    }
    


}
