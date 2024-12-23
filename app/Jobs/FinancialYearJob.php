<?php

namespace App\Jobs;

use App\Models\Management\FinancialYear;
use App\Models\Member\Member;
use App\Models\Member\MemberSavingSummary;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Str;

class FinancialYearJob implements ShouldQueue
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
    public function handle()
    {
        // DB::transaction(function(){
            
        //     $last_year =FinancialYear::latest('id')->first();

        //     FinancialYear::create([
        //         'name'      =>Carbon::parse($last_year->end_date)->format('Y').'/'.Carbon::parse($last_year->end_date)->addYear(1)->format('Y'),
        //         'start_date' =>$last_year->end_date,
        //         'end_date' =>Carbon::parse($last_year->end_date)->addYear(1),
        //     ]);

        //     $last_year->is_active =false;
        //     $last_year->save();
        // });

        $members =Member::whereDoesntHave('member_saving', function ($query) {
            $query->where('financial_year_id',getFinancialYearId());
        })
        ->get();
        foreach ($members as $member) {
            Log::debug($member);
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
}
