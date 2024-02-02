<?php

namespace App\Http\Controllers;

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

    public function calculatePastDueOnStock(){
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
        // $members =MemberSavingSummary::where('stock_for_month','!=',date('F Y'))->get();
        // if ($members->count() > 0) {

        //     foreach ($members as $member) {
        //          // If no stock purchase found, calculate past due days
        //         $currentDate = Carbon::now();
        //         $lastPurchaseDate = Carbon::parse($member->stock_for_month)->endOfMonth();
        
        //         if ($currentDate->greaterThan($lastPurchaseDate)) {
        //             // Check if the next month after the purchase date has passed
        //             $nextMonthAfterPurchase = $lastPurchaseDate->copy()->addMonth();
        //             if ($currentDate->greaterThanOrEqualTo($nextMonthAfterPurchase->endOfMonth())) {
        //                 // Calculate past due days
        //                 $pastDueDays = $currentDate->diffInDays($nextMonthAfterPurchase->endOfMonth());
        //                 $member->past_due_days =$pastDueDays;
        //                 $member->stock_penalty =$pastDueDays * 1500;
        //                 $member->save();
                        
        //                 $stock =StockPastDue::updateOrCreate([
        //                     'member_id' =>$member->id,
        //                     'stock_for_month' =>$nextMonthAfterPurchase->endOfMonth()->format('F Y'),
        //                 ],[
        //                     'past_due_days' =>$pastDueDays,
        //                     'penalty'       =>$pastDueDays * 1500,
        //                     'uuid'          =>Str::orderedUuid(),
        //                 ]);
                        
                      
        //             }
        //         }
        //     }
           
           
        // }else{
        //     $members =Member::doesntHave('member_saving')->get();
        //     foreach ($members as $member) {
        //         $currentDate = Carbon::now();
        //         //$lastPurchaseDate = Carbon::parse('2024-01-01');
        //         $lastPurchaseDate = Carbon::parse('2024-01-01')->endOfMonth();

        //         if ($currentDate->greaterThanOrEqualTo($lastPurchaseDate)) {
        //             // Calculate past due days
        //             $pastDueDays = $currentDate->diffInDays($lastPurchaseDate);

        //             $member_saving =MemberSavingSummary::updateOrcreate([
        //                 'member_id'          =>$member->id,
        //             ],[
        //                 'stock'              =>0,
        //                 'last_stock_amount'  =>0,
        //                 'uuid'               =>(string)Str::orderedUuid(),
        //                 'stock_for_month'    =>Null,
        //                 'past_due_days'      =>$pastDueDays,
        //                 'stock_penalty'      =>$pastDueDays * 1500,
        //             ]); 

        //             $stock =StockPastDue::updateOrCreate([
        //                 'member_id' =>$member->id,
        //                 'stock_for_month' =>$lastPurchaseDate->endOfMonth()->format('F Y'),
        //             ],[
        //                 'past_due_days' =>$pastDueDays,
        //                 'penalty'       =>$pastDueDays * 1500,
        //                 'uuid'          =>Str::orderedUuid(),
        //             ]);
                    
                  
        //         }


        //     }
        // }

        return true;
    }

    public function calculatePastDueOnFee(){
        $members =MemberSavingSummary::with('member')->where('fee_for_month','!=',date('F Y'))
        ->orWhere('fees',null)
       // ->where('member_id',13)
        ->orWhere('fee_for_month',null)
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
                            'member_id' =>$member->id,
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
        else{
            $members =MemberSavingSummary::where('stock',0)->get();
            foreach ($members as $member) {
                $currentDate = Carbon::now();
                // $lastPurchaseDate = Carbon::parse('2024-01-01');
                $lastPurchaseDate = Carbon::parse('2024-01-01')->endOfMonth();

                if ($currentDate->greaterThanOrEqualTo($lastPurchaseDate)) {
                    // Calculate past due days
                    $pastDueDays = $currentDate->diffInDays($lastPurchaseDate);

                    $member->fee_past_due_days =$pastDueDays;
                    $member->fee_penalty =$pastDueDays * 1500;
                    $member->save();

                    $stock =FeePastDue::updateOrCreate([
                        'member_id' =>$member->id,
                        'fee_for_month' =>$lastPurchaseDate->endOfMonth()->format('F Y'),
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
