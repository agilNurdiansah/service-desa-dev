<?php

namespace App\Http\Controllers;

use App\Models\MasterMessage;
use App\Http\Controllers\TokenValidationController;
use Illuminate\Http\Request;

class MasterMessageController extends Controller
{

  

    public function createMasterMessage(Request $request)
    {
        $this->validateRequest($request);

        $token = $request->bearerToken();
        $tokenValidationController = new TokenValidationController();
        $isTokenValid = $tokenValidationController->validationAuth($token);

        if ($isTokenValid) {
            $masterMessage = MasterMessage::create([
                'message' => $request->input('message'),
            ]);

            return response()->json([
                'message' => 'Successfully created',
                'data' => $masterMessage,
            ], 201);
        }

        return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);
    }



    public function getMasterMessages(Request $request)
    {
        $token = $request->bearerToken();

        if (is_null($token)) {
            return response()->json(['error' => 'Unauthorized: Missing token'], 401);
        }

        $tokenValidationController = new TokenValidationController();
        $isTokenValid = $tokenValidationController->validationAuth($token);

        if ($isTokenValid) {
            try {
                $masterMessages = MasterMessage::all();
                return response()->json([
                    'message' => 'Successfully retrieved all messages',
                    'data' => $masterMessages,
                ], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to retrieve messages'], 500);
            }
        }

        return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
    }


    public function deleteMasterMessage(Request $request,$id)
    {
        $token = $request->bearerToken();

        if (is_null($token)) {
            return response()->json(['error' => 'Unauthorized: Missing token'], 401);
        }
    
        $tokenValidationController = new TokenValidationController();
        $isValid = $tokenValidationController->validationAuth($token);
    
        if ($isValid) {
        MasterMessage::destroy($id);
        return response()->json(['message' => 'Successfully deleted'], 204);
    }else{
        return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
    }
}


}
