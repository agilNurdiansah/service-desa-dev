<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\TokenValidationController;
use App\Models\ImageReports;

class ImageReportsController extends Controller
{

    public function createImageReport(Request $request)
    {
        try {
            $this->validateToken($request);
            $this->validateRequest($request);

            $imageName = $this->uploadImage($request);

            $imageData = [
                'id_report' => $request->id_report,
                'image' => $imageName,
            ];

            $data = ImageReports::create($imageData);

            return response()->json([
                'message' => 'Successfully created',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error ' . $e->getMessage()], 500);
        }
    }

    public function deleteImageReport(Request $request, $id)
{
    try {
        $this->validateToken($request);

        $report = ImageReports::findOrFail($id);

        // Delete the image file (optional, adjust path based on your storage)
        if (Storage::disk('public')->exists($report->image)) {
            Storage::disk('public')->delete($report->image);
        }

        $report->delete();

        return response()->json([
            'message' => 'Image report deleted successfully'
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete image report: ' . $e->getMessage()], 500);
    }
}


public function updateImageReport(Request $request, $id)
{
    try {
        $this->validateToken($request);
        $this->validateRequest($request); // Assuming you have validation for update data

        $report = ImageReports::findOrFail($id);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $this->uploadImage($request);

            // Delete the old image file if a new one is uploaded (optional)
            if ($report->image !== $imageName && Storage::disk('public')->exists($report->image)) {
                Storage::disk('public')->delete($report->image);
            }
        }

        $imageData = [
            'id_report' => $request->id_report, // Might not be updatable
            'image' => $imageName ?? $report->image, // Use new image or keep existing
        ];

        $report->update($imageData);  

        return response()->json([
            'message' => 'Image report updated successfully',
            'data' => $report->fresh() // Optional: Refresh data after update
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update image report: ' . $e->getMessage()], 500);
    }
}


    private function uploadImage(Request $request)
    {
        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/admin'), $imageName);
            return $imageName;
        }
        return null;
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
            'id_report' => 'required'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation error', 400);
        }
    }
}
