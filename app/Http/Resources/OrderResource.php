<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'order_number' => $this->order_number,
            'user_id'      => $this->user_id,
            'total_amount' => $this->total_amount,
            'is_placed'    => $this->is_placed,
            'created_at'  => $this->created_at,
            'update_at'   => $this->update_at
        ];
    }
}
