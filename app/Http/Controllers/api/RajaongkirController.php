<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class RajaongkirController extends Controller
{
    protected $API = '2c9a30c9a56275065f07574b67615d40';


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

    
}
