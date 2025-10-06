<?php
namespace App\Http\Traits;

// use Rap2hpoutre\FastExcel\Facades\FastExcel;

use App\Models\Member\MemberSavingSummary;
use Rap2hpoutre\FastExcel\FastExcel;


trait LoanExportTrait {
    

    public function generateLoanExcel($contracts){
        return (new FastExcel($this->loanGenerator($contracts)))->download('LoanReport.xlsx',function($contract){
            $guarantors_ =[];
            foreach ($contract->guarantors as $guarantor) {
                $guarantors_[] =$guarantor->member?->member_name;
            }
            return [
            'Full name'      =>ucwords($contract->member->member_name),
            'Phone Number'   =>$contract->member?->phone_number,
            'ID Number'      =>$contract->member?->id_number,
            'DOB'            =>$contract->member?->dob,
            'Email'          =>$contract->member?->email,
            'Loan Start Date'        =>date('d-M-Y',strtotime($contract->start_date)),
            'Loan Expected End Date' =>date('d-M-Y',strtotime($contract->expected_end_date)),
            'Loan Code'           =>$contract->contract_code,
            'Loan Type'           =>$contract->loan_type?->name,
            'Request Amount'      =>$contract->total_amount,
            'Total Loan Amount'   =>$contract->total_loan_amount,
            'Installment Amount'  =>$contract->installment_amount,
            'Loan Plan'           =>$contract->plan,
            'Loan Status'         =>$contract->status,
            'Total Paid In'       =>$contract->current_balance,
            'Outstanding Balance' =>$contract->outstanding_amount,
            'Actual Outstanding Balance' =>$contract->outstanding_amount + $contract->penalt_amount,
            'Interest Rate'       =>$contract->interest_rate,
            'Interest Amount'     =>$contract->interest_amount,
            'Fees Amount'         =>$contract->fee_amount,
            'Past Due Days'       =>$contract->past_due_days,
            'Current Past Due Days'       =>$contract->highest_past_due_days,
            'Past Due Amount'     =>$contract->past_due_amount,
            'Penalt Amount'       =>$contract->penalt_amount,
            'Penalt Amount Paid'  =>$contract->penalt_amount_paid,
            'Loan Guarantors'     =>implode(',',$guarantors_),
           
            ];
        });
    }

    function loanGenerator($loans) {
        foreach ($loans as $loan) {
            yield $loan;
        }
    }

    public function generateMemberExcel($members){
        return (new FastExcel($this->loanGenerator($members)))->download('MemberReport.xlsx',function($member){
            $total_savings =MemberSavingSummary::where('financial_year_id',getFinancialYearId())->sum('stock');
            return [
            'Full name'      =>ucwords($member->member_name),
            'Phone Number'   =>$member?->phone_number,
            'ID Number'      =>$member?->id_number,
            'DOB'            =>$member?->dob,
            'Email'          =>$member?->email,
            'Total Stock'    =>$member->member_saving->stock,
            'Total Fee'      =>$member->member_saving->fees,
            'Total Stock Penalt'        =>$member->member_saving->stock_penalty,
            'Total Fee Penalt'          =>$member->member_saving->fee_penalty,
            'Total Stock Past Due Days(Current)' =>$member->member_saving->stock_current_pdd,
            'Total Fee Past Due Days(Current)'   =>$member->member_saving->fee_current_pdd,
            'Total Stock Penalt Paid'   =>$member->payments()->where('payment_type','stock penalty')->sum('amount'),
            'Total Fee Penalt Paid'     =>$member->payments()->where('payment_type','fee penalty')->sum('amount'),
            'Stock Percentage'          =>round($member->member_saving->stock / $total_savings,2) * 100,
            ];
        }); 
    }
    
}