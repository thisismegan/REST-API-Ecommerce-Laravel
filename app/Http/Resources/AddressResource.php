<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'name'        => $this->name,
            'province'    => $this->province,
            'regency'     => $this->regency,
            'district'    => $this->district,
            'postalCode'  => $this->postalCode,
            'phoneNumber' => $this->phoneNumber
        ];
    }
}
