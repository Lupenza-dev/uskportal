<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanContractResource extends JsonResource
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
            'debtor'             =>$this->member->first_name.' '.$this->member->last_name,
            'loan_type'          =>$this->loan_type,
            'total_amount'       =>$this->total_amount,
            'total_loan_amount'  =>$this->total_loan_amount,
            'installment_amount' =>$this->installment_amount,
            'plan'               =>$this->plan,
            'current_balance'    =>$this->current_balance,
            'outstanding_amount' =>$this->outstanding_amount,
            'contract_code'      =>$this->contract_code,
            'status'              =>$this->status,
            'start_date'         =>$this->start_date,
            'expected_end_date'  =>$this->expected_end_date,
        ];
    }
}
