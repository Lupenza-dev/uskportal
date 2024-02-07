<?php

namespace App\Jobs;

use App\Models\Member\FeePastDue;
use App\Models\Member\MemberSavingSummary;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Str;

class FeePastDueCalculation implements ShouldQueue
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

    public function handle(){
        Log::info('FeePastDueCalculation');
        $members =MemberSavingSummary::with('member')
        ->where('fee_for_month','!=',date('F Y'))
        ->orWhere('fees',null)
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
                            'past_due_days'   =>$pastDueDays,
                            'penalty'         =>$pastDueDays * 1500,
                            'uuid'            =>Str::orderedUuid(),
                        ]);

                        $member->fee_current_pdd =$pastDueDays;
                        $member->save();


                        $stock->outstanding_amount =$stock->penalty - $stock->penalty_paid;
                        $stock->save();
                        
                      
                    }
                }
            }
           
        }
        

    return true;

    }
}
