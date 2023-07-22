<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class RajaongkirController extends Controller
{
    protected $API = 'b1c35ebae7efc737a060085cc8bfb85f';


    public function getProvince()
    {

        $response = Http::withHeaders([
            'key' => $this->API
        ])->get('https://api.rajaongkir.com/starter/province');

        return response()->json([
            'status' => 200,
            'data'   => $response['rajaongkir']['results']
        ], 200);
    }

    public function getCity($id)
    {
        $response = Http::withHeaders([
            'key' => $this->API
        ])->get('https://api.rajaongkir.com/starter/city?province=' . $id);

        return response()->json([
            'status' => 200,
            'data'   => $response['rajaongkir']['results']
        ], 200);
    }

    public function getPostalCode($id)
    {
        $response = Http::withHeaders([
            'key' => $this->API
        ])->get('https://api.rajaongkir.com/starter/city?id=' . $id);

        return response()->json([
            'status' => 200,
            'data'   => $response['rajaongkir']['results']
        ], 200);
    }
}
