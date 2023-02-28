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
            'total_amount'       =>number_format($this->total_amount),
            'total_loan_amount'  =>number_format($this->total_loan_amount),
            'installment_amount' =>number_format($this->installment_amount),
            'plan'               =>$this->plan,
            'current_balance'    =>number_format($this->current_balance),
            'outstanding_amount' =>number_format($this->outstanding_amount),
            'contract_code'      =>$this->contract_code,
            'status'              =>$this->status,
            'start_date'         =>$this->start_date,
            'expected_end_date'  =>$this->expected_end_date,
        ];
    }
}
