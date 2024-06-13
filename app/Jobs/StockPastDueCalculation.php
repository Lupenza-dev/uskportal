<?php

namespace App\Jobs;

use App\Models\Member\Member;
use App\Models\Member\MemberSavingSummary;
use App\Models\Member\StockPastDue;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Str;

class StockPastDueCalculation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $notificationQueue = 'emails';


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
        Log::info('StockPastDueCalculation');
        $lastMonth = Carbon::parse(Carbon::now()->subMonth()->endOfMonth())->endOfMonth()->format('F Y');
        $members   =MemberSavingSummary::
                    whereNotIn('stock_for_month',[$lastMonth,Carbon::now()->format('F Y')])
                    ->orWhere('stock',0)
                    ->get();
                    
        if ($members->count() > 0) {

            foreach ($members as $member) {
                 // If no stock purchase found, calculate past due days
                $currentDate = Carbon::now();
                $now = Carbon::now();
                $lastPurchaseDate = Carbon::parse($now->subMonth()->endOfMonth())->endOfMonth();
                if ($currentDate->greaterThan($lastPurchaseDate)) {
                    // Check if the next month after the purchase date has passed
                   // if ($currentDate->greaterThanOrEqualTo($nextMonthAfterPurchase->endOfMonth())) {
                        // Calculate past due days
                        $pastDueDays =$currentDate->diffInDays($lastPurchaseDate->endOfMonth());
                       // $member->past_due_days =$member->past_due_days + $pastDueDays;
                       // $member->stock_penalty =$member->stock_penalty + ($pastDueDays * 1500);
                       // $member->save();
                        
                       if ($pastDueDays > 0) {
                            $stock =StockPastDue::updateOrCreate([
                                'member_id' =>$member->member_id,
                                'stock_for_month' =>$lastPurchaseDate->endOfMonth()->format('F Y'),
                            ],[
                                'past_due_days'      =>$pastDueDays,
                                'penalty'            =>$pastDueDays * 1500,
                                'uuid'               =>Str::orderedUuid(),
                            ]);

                        //  $member->stock_current_pdd =$member->stock_current_pdd + $pastDueDays;
                            $member->stock_current_pdd =$member->overDueStock->sum('past_due_days');
                            $member->past_due_days =$member->dueStock->sum('past_due_days');
                            $member->stock_penalty =$member->overDueStock->sum('penalty');
                            $member->save();

                            $stock->outstanding_amount =$stock->penalty - $stock->penalty_paid;
                            $stock->save();
                       }
                       
                        
                      
                    //}
                }
            }
           
           
        }

        return true;
    }
}
