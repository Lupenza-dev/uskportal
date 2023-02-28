<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PaymentResource;
use App\Models\Loan\LoanContract;
use App\Models\Member\MemberSavingSummary;

class HomepageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'payments'     =>PaymentResource::collection($this->payments),
            'group_total'  =>(MemberSavingSummary::sum('total_saving') + MemberSavingSummary::sum('total_monthly_fees')),
            'group_total_loan'      =>LoanContract::sum('total_loan_amount'),
            'group_current_balance' =>LoanContract::sum('current_balance'),
            'group_outstanding'     =>LoanContract::sum('outstanding_amount'),
            'member_saving'         =>$this->member_saving->total_saving,
            'member_monthly_fee'    =>$this->member_saving->total_monthly_fees,
            'member_total_saving'   =>$this->member_saving->total_monthly_fees + $this->member_saving->total_saving,
        ];
    }
}
