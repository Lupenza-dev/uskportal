<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Loan\Installment;
use App\Models\Loan\LoanContract;
use App\Models\Member\FeePastDue;
use App\Models\Member\Member;
use App\Models\Member\MemberSavingSummary;
use App\Models\Member\StockPastDue;
use App\Models\Payment\Payment;
use DateTime;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $members =Member::count();
        $member_savings =MemberSavingSummary::get();
        $loans =LoanContract::get();
        $stock  =StockPastDue::get();
        $fee    =FeePastDue::get();
        $installments =Installment::get();
        return view('dashboards.admin_dashboard',compact('members','member_savings','loans','stock','fee','installments'));
    }

    public function columnChart(){
        return response()->json([
            'stock' =>$this->stockPayment(),
            'loan' =>$this->loanDisbursed(),
        ],200);
    }

    public function stockPayment(){
        $monthly_sales =Payment::
                        whereYear( 'payment_date', date( 'Y'))
                        //->where('payment_for_month',date('F Y'))
                        ->where('payment_type','stock')
                        ->selectRaw( 'SUM(amount) as count, YEAR(payment_date) year,MONTH(payment_date) month ' )
                        ->groupBy( 'year', 'month' )
                        ->get( array( 'month', 'count' ));

        $sales_array = array();
        foreach ( $monthly_sales as $sales ) {

            //$months = array( 1, 2, 3, 4, 5, 6 )
            $dateObj   = DateTime::createFromFormat( '!m', $sales->month );
            $monthName = substr( $dateObj->format( 'F' ), 0, 3 );
            $sale_ = $sales->count;

            $sales_array[$monthName] = round($sales->count);

        }

        $month_array = array();
        for ( $i = 1; $i <= 12; $i++ ) {

            $dateObj   = DateTime::createFromFormat( '!m', $i );
            $monthName = substr( $dateObj->format( 'F' ), 0, 3 );

            if ( array_key_exists( $monthName, $sales_array ) ) {
                $month_array[] = $sales_array[$monthName];
            } else {
                $month_array[] = 0;
            }

        }

        return json_encode($month_array);
    }

    public function loanDisbursed(){
        $monthly_sales =LoanContract::
                        whereYear( 'start_date', date( 'Y'))
                        ->selectRaw( 'SUM(total_amount) as count, YEAR(start_date) year,MONTH(start_date) month ' )
                        ->groupBy( 'year', 'month' )
                        ->get( array( 'month', 'count' ));

        $sales_array = array();
        foreach ( $monthly_sales as $sales ) {

            //$months = array( 1, 2, 3, 4, 5, 6 )
            $dateObj   = DateTime::createFromFormat( '!m', $sales->month );
            $monthName = substr( $dateObj->format( 'F' ), 0, 3 );
            $sale_ = $sales->count;

            $sales_array[$monthName] = round($sales->count);

        }

        $month_array = array();
        for ( $i = 1; $i <= 12; $i++ ) {

            $dateObj   = DateTime::createFromFormat( '!m', $i );
            $monthName = substr( $dateObj->format( 'F' ), 0, 3 );

            if ( array_key_exists( $monthName, $sales_array ) ) {
                $month_array[] = $sales_array[$monthName];
            } else {
                $month_array[] = 0;
            }

        }

        return json_encode($month_array);
    }
}
