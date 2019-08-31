<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
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
            'id'    => $this->id,
            'product_id'  => $this->product_id,
            'user_id' => $this->user_id,
            'created_at'  => $this->created_at,
            'update_at'   => $this->update_at
        ];
    }
}