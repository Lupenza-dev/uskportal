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
                    where(function($query) use ($lastMonth){
                        $query->whereNotIn('stock_for_month',[$lastMonth,Carbon::now()->format('F Y')])
                        ->orWhereNull('last_purchase_date');
                      })
                    ->where('financial_year_id',getFinancialYearId())
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
                                'financial_year_id'  =>getFinancialYearId()
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
           
           
        }else{
            $members =Member::whereDoesntHave('member_saving', function ($query) {
                $query->where('financial_year_id',getFinancialYearId());
            })
            ->get();
            foreach ($members as $member) {
               
                $member_saving =MemberSavingSummary::updateOrcreate([
                    'member_id'          =>$member->id,
                    'financial_year_id'  =>getFinancialYearId()
                ],[
                    'stock'              =>0,
                    'last_stock_amount'  =>0,
                    'uuid'               =>(string)Str::orderedUuid(),
                    'stock_for_month'    =>Null,
                    'past_due_days'      =>0,
                    'stock_penalty'      =>0,
                ]); 


            }
        }

        return true;
    }
}
