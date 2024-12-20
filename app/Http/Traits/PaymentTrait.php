<?php
namespace App\Http\Traits;

use App\Models\Loan\Installment;
use App\Models\Loan\LoanApplication;
use App\Models\Loan\LoanContract;
use App\Models\Member\FeePastDue;
use App\Models\Member\MemberSavingSummary;
use App\Models\Member\StockPastDue;
use Carbon\Carbon;
use Str;
use Log;

trait PaymentTrait {
    
    public function updateInstallment($payment){
        Log::info('Trait');
        $contract     =LoanContract::where('id',$payment->loan_contract_id)->first();
       // $payment      =Payment::where('payment_reference',$payment->payment_reference)->first();

         $paid_amount = $payment->amount;

         $excess_amount = 0;
         while($paid_amount > 0){
             $installment =Installment::where('loan_contract_id',$payment->loan_contract_id)
                                     ->where('outstanding_amount','>',0)
                                     ->orderby('installment_no','ASC')
                                     ->first();
             if(!$installment){
                 $excess_amount = $paid_amount;
                 break;
             }
             //$original_paid_amount = $paid_amount;
             $current_penalt_amount_paid = 0;
             $penalt_amount_paid = 0;
             $penalt_amount = 0;


            

             if($installment->penalt_amount > 0){

                $remain_amount= $paid_amount - $installment->penalt_amount;

                 if($remain_amount < 0){
                     $current_penalt_amount_paid = $paid_amount;
                     $penalt_amount = $installment->penalt_amount - $current_penalt_amount_paid;
                     $penalt_amount_paid = $installment->penalt_amount_paid + $current_penalt_amount_paid;
                 }else{
                     $current_penalt_amount_paid = $installment->penalt_amount;
                     $penalt_amount = 0;
                     $penalt_amount_paid = $installment->penalt_amount_paid + $current_penalt_amount_paid;
                 }

             }else{
                $penalt_amount_paid = $installment->penalt_amount_paid;
             }


             $paid_amount = $paid_amount - $current_penalt_amount_paid;
             
             $paid_out_amount =0;
            
             if($installment->outstanding_amount > $paid_amount){
                 $paid_out_amount = $paid_amount;
                 $outstanding_amount = $installment->outstanding_amount - $paid_out_amount;
                 $current_balance = $installment->current_balance + $paid_out_amount;
                 $status = "OPEN";
             }else{
                 $paid_out_amount = $installment->outstanding_amount;
                 $outstanding_amount = 0;
                 $current_balance = $installment->current_balance + $paid_out_amount;
                 $status = "CLOSED";
             }

             if($penalt_amount_paid > 0 ){
                 $past_due_amount = $installment->past_due_amount - $paid_out_amount;
             }else{
                 $past_due_amount = $installment->past_due_amount;
             }

                 $installment->current_balance            =$current_balance;
                 $installment->outstanding_amount         =$outstanding_amount;
                 $installment->past_due_amount            =$past_due_amount;
                 $installment->penalt_amount_paid         =$penalt_amount_paid;
                 $installment->penalt_amount              =$penalt_amount;
                 $installment->last_paid_amount           =$paid_out_amount;
                 $installment->status                     =$status;
                 $installment->save();




                 $amount_tosettle = $installment->outstanding_amount + $installment->penalt_amount;

                 $total_paid_amount = $paid_out_amount + $current_penalt_amount_paid;
                 $paid_amount = $paid_amount - $paid_out_amount;
                                     
             
         }
         
         $installment_ =Installment::where('loan_contract_id',$payment->loan_contract_id)
                                     ->where('outstanding_amount','>',0)
                                     ->orderby('installment_no','ASC')
                                     ->first();

         $cont_due_day = $contract->past_due_days;
         $next_payment_date = today();
         if($installment_){
             $next_payment_date = $installment_->payment_date;
             $cont_due_day = $installment_->due_days;
         }
         

         $installments =$contract->installments;

         $outstanding_amount = $installments->sum('outstanding_amount');
         $current_balance    = $installments->sum('current_balance');
         $penalt_amount      = $installments->sum('penalt_amount');
         $past_due_amount    = $installments->sum('past_due_amount');
         $penalt_amount_paid = $installments->sum('penalt_amount_paid');

       $contract->current_balance = $current_balance; 
       $contract->date_of_last_payment = $payment->created_at;
       $contract->last_payment_amount = $payment->amount;
       $contract->next_payment_date = $next_payment_date;
       $contract->outstanding_amount = $outstanding_amount;
       $contract->excess_amount = $excess_amount;
       $contract->past_due_days = $cont_due_day;
       $contract->past_due_amount = $past_due_amount;
       $contract->penalt_amount = $penalt_amount;
       $contract->penalt_amount_paid = $penalt_amount_paid;
       $contract->save();

    //    $payment->loan_contract_id =$contract->id;
    //    $payment->save();

       $this->updateStatus($contract);

       return $payment;
       



    }

    public function updateStatus($loanContract){
        if ($loanContract->outstanding_amount <= 0) {
            ### update loan Application
            $loanContract->status ="CLOSED";
            $loanContract->save();

            $loan =LoanApplication::where('id',$loanContract->loan_application_id)->first();
            if ($loan) {
                $loan->level ="CLOSED";
                $loan->save();
            }
           
        }
    }

    public function updateStock($payment){

        $member_saving =MemberSavingSummary::where('member_id',$payment->member_id)
        ->where('financial_year_id',getFinancialYearId())
        ->first();
        if ($member_saving) {
            $stock =$member_saving->stock;
            $member_saving->stock = $stock + $payment->amount;
            $member_saving->last_stock_amount =$payment->amount;
            $member_saving->last_purchase_date =$payment->payment_date;
            $member_saving->stock_for_month  =$payment->payment_for_month;
           // $member_saving->past_due_days  =0;
           // $member_saving->stock_penalty  =0;
            $member_saving->save();
        }else{
            $member_saving =MemberSavingSummary::create([
                'member_id'          =>$payment->member_id,
                'stock'              =>$payment->amount,
                'last_stock_amount'  =>$payment->amount,
                'last_purchase_date' =>$payment->payment_date,
                'uuid'               =>(string)Str::orderedUuid(),
                'stock_for_month'    =>$payment->payment_for_month
            ]); 
        }

        return true;
    }

    public function updateFee($payment){

        $member_saving =MemberSavingSummary::where('member_id',$payment->member_id)
        ->where('financial_year_id',getFinancialYearId())
        ->first();
        if ($member_saving) {
            $fees =$member_saving->fees;
            $member_saving->fees = $fees + $payment->amount;
            $member_saving->last_fee_purchase_date =$payment->payment_date;
            $member_saving->fee_for_month  =$payment->payment_for_month;
            $member_saving->last_fee_amount =$payment->amount;
           // $member_saving->fee_past_due_days  =0;
          //  $member_saving->fee_penalty        =0;
            $member_saving->save();
        }else{
            $member_saving =MemberSavingSummary::create([
                'member_id'          =>$payment->member_id,
                'fees'               =>$payment->amount,
                'last_fee_amount'    =>$payment->amount,
                'last_fee_purchase_date' =>$payment->payment_date,
                'uuid'               =>(string)Str::orderedUuid(),
                'fee_for_month'  =>$payment->payment_for_month
                  
            ]); 
        }

        return true;
    }

    public function updateStockPenalty($payment){

         $paid_amount = $payment->amount;
         $member_saving =MemberSavingSummary::where('member_id',$payment->member_id)
         ->where('financial_year_id',getFinancialYearId())
         ->first();
        $excess_paid =0;
         while($paid_amount > 0){
            // check if Penalt Exist
            $stock_penalty_data =StockPastDue::where('member_id',$member_saving->member_id)
                                ->where('paid_status',0)
                                ->where('outstanding_amount','>',0)
                                ->where('financial_year_id',getFinancialYearId())
                                ->orderBy('id','ASC')
                                ->first();

            if(!$stock_penalty_data){
                $excess_paid =$paid_amount;
                break;
            }

            //change

           // check if Outstanding amount is greated than  paid
            $paid_out_amount =0;
            if ($stock_penalty_data->outstanding_amount > $paid_amount) {
                $paid_out_amount = $paid_amount;
                $outstanding_amount   = $stock_penalty_data->outstanding_amount - $paid_amount;
                $penalty_paid         = $stock_penalty_data->penalty_paid + $paid_amount;
                $status = 0;
            } else {
                $paid_out_amount =$stock_penalty_data->outstanding_amount;
                $outstanding_amount = 0;
                $penalty_paid = $stock_penalty_data->penalty_paid + $stock_penalty_data->outstanding_amount;
                $status = 1;
            }
            

            $stock_penalty_data->current_balance            =$penalty_paid;
            $stock_penalty_data->outstanding_amount         =$outstanding_amount;
            $stock_penalty_data->penalty_paid                =$penalty_paid;
        // $stock_penalty_data->penalty_amount              =$penalt_amount;
            $stock_penalty_data->last_paid_amount           =$paid_amount;
            $stock_penalty_data->paid_status                =$status;
            $stock_penalty_data->payment_id                 =$payment->id;
            $stock_penalty_data->save();

            $paid_amount = $paid_amount - $paid_out_amount;
             
        }

       $new_stock =StockPastDue::where('member_id',$member_saving->member_id)
       ->where('financial_year_id',getFinancialYearId())
       ->get();

       $member_saving->stock_penalty             =$new_stock->sum('outstanding_amount');
       $member_saving->stock_penalty_excess_paid =$member_saving->stock_penalty_excess_paid + $excess_paid;
       $member_saving->stock_current_pdd         =$new_stock->sum('outstanding_amount') > 0 ?  $member_saving->past_due_days : 0;
       $member_saving->save();

       return true;

    }

    public function updateFeePenalty($payment){

        $paid_amount = $payment->amount;
        $member_saving =MemberSavingSummary::where('member_id',$payment->member_id)        
                        ->where('financial_year_id',getFinancialYearId())
                        ->first();
       $excess_paid =0;
        while($paid_amount > 0){
           // check if Penalt Exist
           $fee_penalty_data =FeePastDue::where('member_id',$member_saving->member_id)
                               ->where('paid_status',0)
                               ->where('outstanding_amount','>',0)
                               ->where('financial_year_id',getFinancialYearId())
                               ->orderBy('id','ASC')
                               ->first();

           if(!$fee_penalty_data){
               $excess_paid =$paid_amount;
               break;
           }

           //change

          // check if Outstanding amount is greated than  paid
           $paid_out_amount =0;
           if ($fee_penalty_data->outstanding_amount > $paid_amount) {
               $paid_out_amount = $paid_amount;
               $outstanding_amount   = $fee_penalty_data->outstanding_amount - $paid_amount;
               $penalty_paid         = $fee_penalty_data->penalty_paid + $paid_amount;
               $status = 0;
           } else {
               $paid_out_amount =$fee_penalty_data->outstanding_amount;
               $outstanding_amount = 0;
               $penalty_paid = $fee_penalty_data->penalty_paid + $fee_penalty_data->outstanding_amount;
               $status = 1;
           }
           

           $fee_penalty_data->current_balance            =$penalty_paid;
           $fee_penalty_data->outstanding_amount         =$outstanding_amount;
           $fee_penalty_data->penalty_paid                =$penalty_paid;
       // $fee_penalty_data->penalty_amount              =$penalt_amount;
           $fee_penalty_data->last_paid_amount           =$paid_amount;
           $fee_penalty_data->paid_status                =$status;
           $fee_penalty_data->payment_id                 =$payment->id;
           $fee_penalty_data->save();

           $paid_amount = $paid_amount - $paid_out_amount;
            
       }

      $penalty_remain =$member_saving->stock_penalty - $payment->amount;

      $new_stock =FeePastDue::where('member_id',$member_saving->member_id)        
                ->where('financial_year_id',getFinancialYearId())
                ->get();

      $member_saving->fee_penalty               =$new_stock->sum('outstanding_amount');
      $member_saving->fee_penalty_excess_paid   =$member_saving->fee_penalty_excess_paid + $excess_paid;
      $member_saving->fee_current_pdd           =$new_stock->sum('outstanding_amount') > 0 ?  $member_saving->fee_past_due_days : 0;
      $member_saving->save();

      return true;
      



   }

    
}