<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AccountVerifiedUser;
use App\Models\User;
use App\Http\Controllers\TokenValidationController;


class UserController extends Controller
{


    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'nik' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $token = auth()->attempt($validator->validated());
        

        if (!$token) {
            return response()->json(['error' => 'Sign no user or unauthorized'], 401);
        }else{
           $data = AccountVerifiedUser::where('userId',auth()->user()->id)->first();
            return $this->createNewToken($token,$data->is_verified);

        }

    
    }

    public function updateUserVerified(Request $request, $id) {
        try {
            $token = $request->bearerToken();

            if (!$token) {
                return response()->json(['error' => 'Unauthorized: Missing token'], 401);
            }

            $tokenValidationController = new TokenValidationController();
            $isTokenValid = $tokenValidationController->validationAuth($token);

            if (!$isTokenValid) {
                return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
            }

            $userVerified = AccountVerifiedUser::findOrFail($id);
            $userVerified->is_verified = 1;
            $userVerified->save();

            return response()->json([
                'message' => 'User updated verified successfully',
                'data' => $userVerified
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function getUserList(Request $request)
    {
        $perPage = $request->input('limit') ?? 10;
        $page = $request->input('page_number') ?? 1;
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Unauthorized: Missing token'], 401);
        }

        $tokenValidationController = new TokenValidationController();
        $isTokenValid = $tokenValidationController->validationAuth($token);

        if (!$isTokenValid) {
            return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
        }

            $users = User::orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);
            foreach ($users as $key => $user) {
                $user->is_verified = AccountVerifiedUser::where('userId', $user->id)->value('is_verified');
            }

            return response()->json([
                'message' => 'Users retrieved successfully',
                'data' => $users
            ], 200);
        

        return response()->json(['error' => 'Limit and offset must be provided'], 404);
    }
    


  
    public function register(Request $request) {
        $validator = Validator($request->all(), [
            'name' => 'required|string|between:2,100',
            'nik'=>'required|string',
            'role'=>'required|string',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }


        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

                $dataVerified  = [
                    'userId' => $user->id,
                    'is_verified' => 0,
            ];
         AccountVerifiedUser::create($dataVerified);

        return response()->json([
            'message' => 'User successfully registered',
            'data' => $user
        ], 201);
    }
      
    protected function createNewToken($token,$isVerifiedUser){
        return response()->json([
            'access_token' => $token,
            'is_verified' => $isVerifiedUser,
            'token_type' => 'bearer',
            'data' => auth()->user()
        ]);
    }



   
}