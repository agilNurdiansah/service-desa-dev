<?php

namespace App\Http\Controllers;


use App\Models\MasterTypeMessage;
use App\Http\Controllers\TokenValidationController;
use Illuminate\Http\Request;


class MasterTypeMessageController extends Controller
{


    public function createMasterTypeMessage(Request $request)
    {
        $this->validateRequest($request);

        $token = $request->bearerToken();
        $tokenValidationController = new TokenValidationController();
        $isTokenValid = $tokenValidationController->validationAuth($token);

        if ($isTokenValid) {
            $masterMessage = MasterTypeMessage::create([
                'message' => $request->input('message'),
                'type_message' => $request->input('type_message'),
                'description' => $request->input('description'),
            ]);

            return response()->json([
                'message' => 'Successfully created',
                'data' => $masterMessage,
            ], 201);
        }

        return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
    }

    public function getMasterTypeMessages(Request $request)
    {

        $token = $request->bearerToken();
        $tokenValidationController = new TokenValidationController();
        $isTokenValid = $tokenValidationController->validationAuth($token);
        $perPage = $request->input('limit') ?? 10;
        $page = $request->input('page_number') ?? 1;


        if ($isTokenValid) {
            $masterTypeMessages = MasterTypeMessage::orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'message' => 'Successfully retrieved all type messages',
                'data' => $masterTypeMessages,
            ], 200);
        }
        return response()->json(['error' => 'Unauthorized: Invalid token'], 401);

    }



    public function deleteMasterTypeMessage(Request $request,$id)
    {
        $token = $request->bearerToken();

        if (is_null($token)) {
            return response()->json(['error' => 'Unauthorized: Missing token'], 401);
        }
    
        $tokenValidationController = new TokenValidationController();
        $isValid = $tokenValidationController->validationAuth($token);
    
        if ($isValid) {
            MasterTypeMessage::destroy($id);
        return response()->json(['message' => 'Successfully deleted'], 204);
    }else{
        return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
    }
}



    private function validateRequest(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'type_message' => 'required',
            'description' => 'required',
        ]);
    }


}
