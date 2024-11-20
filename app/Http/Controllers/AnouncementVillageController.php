<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AnouncementVillage;
use App\Http\Controllers\TokenValidationController;

class AnouncementVillageController extends Controller
{
    public function createAnouncement(Request $request)
    {
        try {
            $token = $request->bearerToken();

            if (is_null($token)) {
                return response()->json(['error' => 'Unauthorized: Missing token'], 401);
            }

            $tokenValidationController = new TokenValidationController();
            $isTokenValid = $tokenValidationController->validationAuth($token);

            if (!$isTokenValid) {
                return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
            }

            $validator = Validator($request->all(), [
                'content' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $imageName = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('images/admin'), $imageName);
            }

            $anouncementData = [
                'content' => $request->content,
                'image' => $imageName,
            ];

            $anouncement = AnouncementVillage::create($anouncementData);

            return response()->json(['message' => 'Successfully created', 'data' => $anouncement], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error ' . $e->getMessage()], 500);
        }
    }

    public function updateAnouncement(Request $request, $id) {
        try {

            $token = $request->bearerToken();

            if (is_null($token)) {
                return response()->json(['error' => 'Unauthorized: Missing token'], 401);
            }


            $tokenValidationController = new TokenValidationController();
            $isTokenValid = $tokenValidationController->validationAuth($token);

            if (!$isTokenValid) {
                return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
            }
            $validator = Validator($request->all(), [
                'content' => 'required'
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
    
            $anouncementVillage = AnouncementVillage::findOrFail($id);  // Ensure anouncementVillage exists
    
            $anouncementVillage->content = $request->content;
    
            // Handle image update (optional)
            $image = $request->file('image');
            $imageName = null;
    
            if ($image) {
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('images/admin'), $imageName);
    
                if ($anouncementVillage->image && file_exists(public_path('images/admin/' . $anouncementVillage->image))) {
                    unlink(public_path('images/admin/' . $anouncementVillage->image));
                }
    
                $anouncementVillage->image = $imageName;
            }
    
            $data = [
                'content' => $request->content,
                'image' => $anouncementVillage->image,
             ];

             $anouncementVillage->update($data);    
            return response()->json([
                'message' => 'anouncementVillage updated successfully',
                'data' => $anouncementVillage->fresh()
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error ' . $e->getMessage()], 500);
        }
    }

    public function deleteAnouncement(Request $request,$id) {
        try {

            $token = $request->bearerToken();

            if (is_null($token)) {
                return response()->json(['error' => 'Unauthorized: Missing token'], 401);
            }


            $tokenValidationController = new TokenValidationController();
            $isTokenValid = $tokenValidationController->validationAuth($token);

            if (!$isTokenValid) {
                return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
            }

            $anouncementVillage = AnouncementVillage::findOrFail($id);
    
            if ($anouncementVillage->image) {
                unlink(public_path('images/admin/' . $anouncementVillage->image));

            }
    
            $anouncementVillage->delete();
    
            return response()->json(['message' => 'anouncementVillage deleted successfully'], 204);
        } catch (\ModelNotFoundException $e) {
            return response()->json(['error' => 'anouncementVillage not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error ' . $e->getMessage()], 500);
        }
    }
    

    public function getAnouncements(Request $request) {
        try {
          
            $perPage = $request->input('limit') ?? 10;
            $page = $request->input('page_number') ?? 1;

            $id = $request->get("id");

            $token = $request->bearerToken();

            if (is_null($token)) {
                return response()->json(['error' => 'Unauthorized: Missing token'], 401);
            }


            $tokenValidationController = new TokenValidationController();
            $isTokenValid = $tokenValidationController->validationAuth($token);

            if (!$isTokenValid) {
                return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
            }

            if ($id) {
                $anouncementVillage = AnouncementVillage::findOrFail($id);
                return response()->json([
                    'message' => 'anouncementVillage get successfully',
                    'data' => $anouncementVillage], 200);
            } else {
                    $anouncementVillage = AnouncementVillage::orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);
                    return response()->json([
                        'message' => 'anouncementVillage get successfully',
                        'data' => $anouncementVillage], 200);
               


            }
        } catch (\ModelNotFoundException $e) {
            return response()->json(['error' => 'anouncementVillage not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error ' . $e->getMessage()], 500);
        }
    }
    
}
