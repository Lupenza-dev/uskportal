<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'amount'            =>number_format($this->amount),
            'payment_reference' =>$this->payment_reference,
            'payment_type'      =>$this->payment_type,
            'payment_date'      =>$this->payment_date ?? $this->created_at
        ];
    }
}
