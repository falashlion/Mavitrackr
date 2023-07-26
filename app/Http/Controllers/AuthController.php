<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\users;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;
//use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    /*public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    */
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	/*$validator = Validator::make($request->all(), [
            'user_matricule' => 'required|string',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
        */
        $creds = $request->only(['user_matricule', 'Password']);
        if(!$token = auth()->attempt($creds)){
            return response()->json(["Error" => "Invalid user_matricule/Password"], 401);
        };
        return response()->json(['token'=>$token]);

    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /*public function register(Request $request)
        $user = users::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
    */
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /*
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse

    public function refresh() {
        return $this->createNewToken(auth()->$this->refresh());
    }
    */
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /*protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->$this->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);

    }*/
}
