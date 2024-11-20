<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TokenValidationController;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController
{


    public function createReport(Request $request)
    {
       
        $token = $request->bearerToken();
        $tokenValidationController = new TokenValidationController();
        $isTokenValid = $tokenValidationController->validationAuth($token);

        
        if ($isTokenValid) {
            $request->validate([
                'name_pelapor' => 'required',
                'date_pelapor' => 'required',
                'type_category' => 'required',
                'location' => 'required',
                'desc_report' => 'required',
            ]);

            $reportData = Report::create([
                'name_pelapor' => $request->input('name_pelapor'),
                'date_pelapor' => $request->input('date_pelapor'),
                'type_category' => $request->input('type_category'),
                'location' => $request->input('location'),
                'desc_report' =>  $request->input('desc_report'),
            ]);

            return response()->json([
                'message' => 'Successfully created',
                'data' => $reportData,
            ], 201);
        }

        return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
       
    }


    public function manageReport(Request $request)
    {
        $token = $request->bearerToken();
        $tokenValidationController = new TokenValidationController();
        $isTokenValid = $tokenValidationController->validationAuth($token);

        if (!$isTokenValid) {
            return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
        }

        $method = $request->method();
        $reportId = $request->input('id');
        $reportData = $request->all();
        $perPage = $request->input('limit') ?? 10;
        $page = $request->input('page_number') ?? 1;

        switch ($method) {
            case 'GET':
                $reports = Report::with('imageReports')->orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);
                return response()->json(['message' => 'Success', 'data' => $reports], 200);
            case 'DELETE':
                $report = Report::find($reportId);
                if (!$report) {
                    return response()->json(['error' => 'Report not found'], 404);
                }
                $report->delete();
                return response()->json(['message' => 'Report deleted'], 200);
            case 'POST':
                $report = Report::find($reportId);
                if (!$report) {
                    return response()->json(['error' => 'Report not found'], 404);
                }
                $report->update($reportData);
                return response()->json(['message' => 'Report updated'], 200);
            default:
                return response()->json(['error' => 'Method not allowed'], 405);
        }
    }
      
    
}
