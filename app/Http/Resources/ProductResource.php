<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id'          => $this->id,
            'sku'         => $this->sku,
            'slug'        => $this->slug,
            'name'        => $this->name,
            'photo'       => env('APP_URL') .'/storage/uploads/images/products/'. $this->photo,
            'description' => $this->description,
            'price'       => number_format((float) $this->price, 2, '.', ','),
            'stock'       => $this->stock,
            'like_count'  => $this->like_count,
            'is_active'   => $this->is_active,
            'created_at'  => $this->created_at,
            'update_at'   => $this->update_at
        ];
    }
}
