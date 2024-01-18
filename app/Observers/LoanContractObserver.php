<?php

namespace App\Observers;

use App\Models\Loan\LoanContract;
use App\Models\Loan\LoanApplication;
use App\Models\Loan\Installment;
use Carbon\Carbon;
use Str;

class LoanContractObserver
{
    /**
     * Handle the LoanContract "created" event.
     *
     * @param  \App\Models\Loan\LoanContract  $loanContract
     * @return void
     */
    public function created(LoanContract $loanContract)
    {
        $plan =$loanContract->plan;

        for ($i=1; $i <= $plan; $i++) { 
            $start_date = Carbon::parse($loanContract->start_date);
            $installment =Installment::create([
                'installment_no' =>$i,
                'installment_amount' =>$loanContract->installment_amount,
                'outstanding_amount' =>$loanContract->installment_amount,
                'loan_contract_id'   =>$loanContract->id,
                'payment_date'       =>$start_date->addMonths($i),
                'uuid'               =>(string)Str::orderedUuid()
            ]);
        }

        $loan_application =LoanApplication::where('id',$loanContract->loan_application_id)->first();
        $loan_application->level ="GRANTED";
        $loan_application->save();
    }

    /**
     * Handle the LoanContract "updated" event.
     *
     * @param  \App\Models\Loan\LoanContract  $loanContract
     * @return void
     */
    public function updated(LoanContract $loanContract)
    {
        //
    }

    /**
     * Handle the LoanContract "deleted" event.
     *
     * @param  \App\Models\Loan\LoanContract  $loanContract
     * @return void
     */
    public function deleted(LoanContract $loanContract)
    {
        //
    }

    /**
     * Handle the LoanContract "restored" event.
     *
     * @param  \App\Models\Loan\LoanContract  $loanContract
     * @return void
     */
    public function restored(LoanContract $loanContract)
    {
        //
    }

    /**
     * Handle the LoanContract "force deleted" event.
     *
     * @param  \App\Models\Loan\LoanContract  $loanContract
     * @return void
     */
    public function forceDeleted(LoanContract $loanContract)
    {
        //
    }
}
