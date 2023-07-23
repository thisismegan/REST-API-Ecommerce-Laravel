<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressStoreRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{

    use HttpResponses;

    public function index()
    {
        $address = Address::where('user_id', Auth::user()->id)->get();
        if ($address->count() > 0) {
            return $this->success($address, 'ok', 200);
        } else {
            return $this->failed('', 'Address not found', 200);
        }
    }


    public function store(AddressStoreRequest $request)
    {

        $request->validated($request->all());

        $address = Address::create([
            'user_id'       => Auth::user()->id,
            'name'          => $request->name,
            'city_id'       => $request->city_id,
            'fullAddress'   => $request->fullAddress,
            'phoneNumber'   => $request->phoneNumber
        ]);

        return $this->success($address, 'Successfully', 201);
    }


    public function show($id)
    {

        $address = Address::where('id', $id)->where('user_id', Auth::user()->id)->get();

        if ($address->count() < 1) {
            return $this->failed('', 'Address not found', 404);
        }
        return $this->success([
            'address' => $address
        ], 'Request was successfully', 200);
    }


    public function update(Request $request, Address $address)
    {
        if (Auth::user()->id !== $address->user_id) {
            return $this->failed('', "Access Denied!", 401);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required',
            'city_id'     => 'required',
            'fullAddress' => 'required',
            'phoneNumber' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return $this->failed('', $validator->errors(), 401);
        }


        $address->update($request->all());

        return $this->success(new AddressResource($address), 'Address has been updated', 200);
    }

    public function destroy(Address $address)
    {
        $this->userAccess($address->user_id);
        $address->delete();
        return $this->success('', 'Successfully', 200);
    }
}
