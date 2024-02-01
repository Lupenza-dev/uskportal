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
        $members =MemberSavingSummary::where('stock_for_month','!=',date('F Y'))->get();
        if ($members->count() > 0) {

            foreach ($members as $member) {
                 // If no stock purchase found, calculate past due days
                $currentDate = Carbon::now();
                $lastPurchaseDate = Carbon::parse($member->stock_for_month)->endOfMonth();
        
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
                            'member_id' =>$member->id,
                            'stock_for_month' =>$nextMonthAfterPurchase->endOfMonth()->format('F Y'),
                        ],[
                            'past_due_days' =>$pastDueDays,
                            'penalty'       =>$pastDueDays * 1500,
                            'uuid'          =>Str::orderedUuid(),
                        ]);
                        
                      
                    }
                }
            }
           
           
        }else{
            $members =Member::doesntHave('member_saving')->get();
            foreach ($members as $member) {
                $currentDate = Carbon::now();
                //$lastPurchaseDate = Carbon::parse('2024-01-01');
                $lastPurchaseDate = Carbon::parse('2024-01-01')->endOfMonth();

                if ($currentDate->greaterThanOrEqualTo($lastPurchaseDate)) {
                    // Calculate past due days
                    $pastDueDays = $currentDate->diffInDays($lastPurchaseDate);

                    $member_saving =MemberSavingSummary::updateOrcreate([
                        'member_id'          =>$member->id,
                    ],[
                        'stock'              =>0,
                        'last_stock_amount'  =>0,
                        'uuid'               =>(string)Str::orderedUuid(),
                        'stock_for_month'    =>Null,
                        'past_due_days'      =>$pastDueDays,
                        'stock_penalty'      =>$pastDueDays * 1500,
                    ]); 

                    $stock =StockPastDue::updateOrCreate([
                        'member_id' =>$member->id,
                        'stock_for_month' =>$lastPurchaseDate->endOfMonth()->format('F Y'),
                    ],[
                        'past_due_days' =>$pastDueDays,
                        'penalty'       =>$pastDueDays * 1500,
                        'uuid'          =>Str::orderedUuid(),
                    ]);
                    
                  
                }


            }
        }

        return true;
    }
}
