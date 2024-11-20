<?php
namespace App\Http\Controllers;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class TokenValidationController extends Controller
{
    public function validationAuth($token)
    {
        try {
            $user = JWTAuth::parseToken($token);
            if ($user->user()) {
                return true;
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Unauthorized: Token expired'], 401);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Unauthorized: Token error'], 401);
        }
    }

}