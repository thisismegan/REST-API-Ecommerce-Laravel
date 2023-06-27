<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $role = Role::all();

        return $this->success($role, '');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'roleName' => 'required|max:15'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $role = Role::create([
            'roleName' => $request->roleName
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil',
            'data'    => $role
        ], 200);
    }
}
