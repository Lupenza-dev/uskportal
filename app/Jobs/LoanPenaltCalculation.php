<?php

namespace App\Jobs;

use App\Models\Loan\Installment;
use App\Models\Loan\LoanContract;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LoanPenaltCalculation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
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
