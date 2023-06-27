<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'province'    => $this->province,
            'regency'     => $this->regency,
            'subdistrict' => $this->subdistrict,
            'postalCode'  => $this->postalCode,
            'phoneNumber' => $this->phoneNumber
        ];
    }
}
