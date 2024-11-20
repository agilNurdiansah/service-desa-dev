<?php

namespace App\Http\Controllers;
use App\Models\MasterRole;
use Illuminate\Http\Request;
use App\Http\Controllers\TokenValidationController;

class MasterRoleController extends Controller
{

    public function createMasterRole(Request $request){
        $validator = Validator($request->all(), [
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $dataRole = [
            'role' => $request->role
            ];

        $data = MasterRole::create($dataRole);

    return response()->json([
        'message' => 'Successfully created',
        'data' => $data
    ], 201);
    }


    public function getMasterRole(Request $request){
        $data = MasterRole::all();
    return response()->json([
        'message' => 'Successfully get all',
        'data' => $data
    ], 201);
    }


    public function deleteMasterRole(Request $request,$id){
        $dataRole = MasterRole::findOrFail($id);
        $dataRole->delete();
    return response()->json([
        'message' => 'Successfully delete',
    ], 204);
    }
}
