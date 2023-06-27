<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id'        => $this->id,
            'firstName' => $this->firstName,
            'lastName'  => $this->lastName,
            'gender'    => $this->gender,
            'email'     => $this->email,
            'email_verified_at'    => $this->email_verified_at,
            'userImage' => $this->userImage,
            'role'      => new RoleResource($this->role),
            'address'   => $this->address
        ];
    }
}
