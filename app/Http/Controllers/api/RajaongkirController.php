<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;

class RajaongkirController extends Controller
{

    public function getProvince()
    {

        $province = Province::all();

        return response()->json([
            'status' => 200,
            'data'   => $province
        ], 200);
    }

    public function getCity($id)
    {

        $city = City::where('province_id', $id)->get();

        return response()->json([
            'status' => 200,
            'data'   => $city
        ], 200);
    }

    public function getPostalCode($id)
    {

        $postal_code = City::where('city_id', $id)->first();

        return response()->json([
            'status' => 200,
            'data'   => $postal_code
        ], 200);
    }
}
