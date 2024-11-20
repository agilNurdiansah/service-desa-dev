<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LetterSubmission;
use App\Http\Controllers\TokenValidationController;

class LetterSubmissionController extends Controller
{

    public function createLetter(Request $request)
    {
        $this->validateRequest($request);

        $this->validateToken($request);

            $data = LetterSubmission::create([
                'type_letter' => $request->input('type_letter'),
                'id_user_maker' => $request->input('id_user_maker'),
                'name_user_maker' => $request->input('name_user_maker'),
                'type_maker' => $request->input('type_maker'),
                'status' => $request->input('status'),
                'letter' => $request->input('letter')
            ]);


            return response()->json([
                'message' => 'Successfully created',
                'data' => $data,
            ], 201);
        

        return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
    }


    public function updateLetter(Request $request, $id)
    {
        $this->validateRequest($request);

        $this->validateToken($request);

        $isTokenValid = true;

        if ($isTokenValid) {
            $data = LetterSubmission::find($id);
            if ($data) {
                $data->type_letter = $request->input('type_letter');
                $data->id_user_maker = $request->input('id_user_maker');
                $data->type_maker = $request->input('type_maker');
                $data->status = $request->input('status');
                $data->name_user_maker = $request->input('name_user_maker');
                $data->letter = $request->input('letter');

                if ($data->save()) {
                    return response()->json([
                        'message' => 'Successfully updated',
                        'data' => $data,
                    ], 200);
                }
            }

            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
    }


    public function updateLetterStatus(Request $request, $id)
    {

        $this->validateToken($request);

        $isTokenValid = true;

        if ($isTokenValid) {
            $data = LetterSubmission::find($id);
            if ($data) {
            
                $data->status = $request->input('status');
        
                if ($data->update()) {
                    return response()->json([
                        'message' => 'Successfully updated status',
                        'data' => $data,
                    ], 200);
                }
            }

            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
    }


        public function getAllSubmissionsLetter(Request $request)
        {

            $this->validateToken($request);

            $perPage = $request->input('limit') ?? 10;
            $page = $request->input('page_number') ?? 1;


            $submissions = LetterSubmission::orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);
            return response()->json($submissions, 200);
        }
    
        public function getSubmissionById($id,Request $request)
        {

            $this->validateToken($request);

            $perPage = $request->input('limit') ?? 10;
            $page = $request->input('page_number') ?? 1;
            $submission = LetterSubmission::where('id', $id)->orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);
            if ($submission) {
                return response()->json([
                    'message' => 'Submission letter retrieved successfully',
                    'data' => $submission
                ], 200);
            } else {
                return response()->json(['error' => 'Submission not found'], 404);
            }
        }
    
        public function deleteSubmission($id,Request $request)
        {

            $this->validateToken($request);

            $submission = LetterSubmission::find($id);
            if ($submission) {
                $submission->delete();
                return response()->json(['message' => 'Submission deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Submission not found'], 404);
            }
        }
    


        private function validateToken(Request $request)
        {
            $token = $request->bearerToken();
            if (!$token) {
                throw new \Exception('Unauthorized: Missing token', 401);
            }
    
            $tokenValidationController = new TokenValidationController();
            if (!$tokenValidationController->validationAuth($token)) {
                throw new \Exception('Unauthorized: Invalid token', 401);
            }
        }

        private function validateRequest(Request $request)
        {
            $validator = Validator($request->all(), [
                'type_letter' =>'required',
                'name_user_maker'=>'required',
                'id_user_maker' => 'required',
                'type_maker' =>'required',
                'status' => 'required',
                'letter' =>'required'  
              ]);
    
            if ($validator->fails()) {
                throw new \Exception('Validation error', 400);
            }
        }
    
    
}
