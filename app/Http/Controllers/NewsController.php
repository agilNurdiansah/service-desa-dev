<?php

namespace App\Http\Controllers;
use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\TokenValidationController;



class NewsController extends Controller
{

    public function createNews(Request $request)
    {
        try {
            $this->validateToken($request);
            $this->validateRequest($request);

            $imageName = $this->uploadImage($request);

            $newsData = [
                'content' => $request->content,
                'image' => $imageName,
            ];

            $news = News::create($newsData);

            return response()->json([
                'message' => 'Successfully created',
                'data' => $news
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error ' . $e->getMessage()], 500);
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
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation error', 400);
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

    public function updateNews(Request $request, $id) {
        try {
            $this->validateToken($request);

            $validator = Validator($request->all(), [
                'content' => 'required'
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
    
            $news = News::findOrFail($id);  // Ensure news exists
    
            $news->content = $request->content;
    
            // Handle image update (optional)
            $image = $request->file('image');
            $imageName = null;
    
            if ($image) {
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('images/admin'), $imageName);
    
                if ($news->image && file_exists(public_path('images/admin/' . $news->image))) {
                    unlink(public_path('images/admin/' . $news->image));
                }
    
                $news->image = $imageName;
            }
    
            $data = [
                'content' => $request->content,
                'image' => $news->image,
             ];

             $news->update($data);    
            return response()->json([
                'message' => 'News updated successfully',
                'data' => $news->fresh()
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error ' . $e->getMessage()], 500);
        }
    }

    public function deleteNews(Request $request,$id) {
        try {
            $this->validateToken($request);

            $news = News::findOrFail($id);
    
            if ($news->image) {
                unlink(public_path('images/admin/' . $news->image));

            }
    
            $news->delete();
    
            return response()->json(['message' => 'News deleted successfully'], 204);
        } catch (\ModelNotFoundException $e) {
            return response()->json(['error' => 'News not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error ' . $e->getMessage()], 500);
        }
    }
    

    public function getNews(Request $request)
    {
        try {
            $this->validateToken($request);

            $newsId = $request->input('id');
            $perPage = $request->input('limit') ?? 10;
              $page = $request->input('page_number') ?? 1;


            if ($newsId) {
                $news = News::findOrFail($newsId);
                return response()->json([
                    'message' => 'News retrieved successfully',
                    'data' => $news
                ], 200);
            }

                $news = News::orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);
                return response()->json([
                    'message' => 'News retrieved successfully',
                    'data' => $news
                ], 200);
            

            return response()->json(['error' => 'Limit and offset parameters are required'], 400);
        } catch (\ModelNotFoundException $e) {
            return response()->json(['error' => 'News not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error ' . $e->getMessage()], 500);
        }
    }
    
    
   
}
