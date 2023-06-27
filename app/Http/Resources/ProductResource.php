<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'category'    => $this->category,
            'productName' => new $this->productName,
            'description' => $this->description,
            'quantity'    => $this->quantity,
            'price'       => $this->price,
            'weight'      => $this->weight,
            'status'      => $this->status,
            'image'       => ImageResource::collection($this->image)
        ];
    }
}
