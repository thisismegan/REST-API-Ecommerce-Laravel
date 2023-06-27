<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class OrderResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id'             => $this->id,
            'user'           =>
            [
                'id'    => $this->user->id,
                'name'  => $this->user->firstName . " " . $this->user->lastName,
            ],
            'order_date'     => $this->order_date,
            'order_total'    => $this->order_total,
            'order_status'   => $this->order_status->orderStatusName,
            'invoice'        => $this->invoice,
            'detail_product' => OrderDetailResource::collection($this->order_detail),
            'address'        => $this->address
        ];
    }
}
