<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Access;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;



class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
//    public function __construct() {
//        $this->middleware('auth:api', ['except' => ['login', 'submitResetPasswordForm', 'updateusers', 'logout', 'register', 'deleteuser', 'getusers', 'getdepartments', 'createdepartments', 'updatedepartments', 'deletedepartments', 'getusersbyid']]);
//     }
// public function __construct()
//     {
//         $this->middleware('auth:api', ['except' => ['login', 'register']]);
//     }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public $token = true;
    public function register(Request $request){

        $validatedData = $request->validate([
            'user_matricule' => 'required|string',
            'password'=>'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'profile_image'=> 'string',
            'phone' =>'numeric',
            'address' =>'string',
            'gender'=> 'string',
            'departments_id'=> 'integer',
            'positions_id'=> 'integer',
            'is_manager' => 'boolean',

        ]);

            $user= User::create([
                'user_matricule' => $validatedData['user_matricule'],
                'password' => ($validatedData['password']),
               'first_name' => $validatedData['first_name'],
               'last_name' => $validatedData['last_name'],
               'email' => $validatedData['email'],
               'profile_image' => $validatedData['profile_image'],
               'phone' => $validatedData['phone'],
               'address' => $validatedData['address'],
               'gender' => $validatedData['gender'],
               'departments_id'=> $validatedData[ 'departments_id'],
               'positions_id'=> $validatedData['positions_id'],
               'is_manager' => $validatedData['is_manager'],

        ]);





         return response()->json([
            'status'=> 'success',
            'message'=> 'user successfully created',
            'user'=> $user,
            'role' => $user->roles()->get()->pluck(['title']),


         ]);
            }



    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validate = $request->validate([
            'user_matricule' => 'required|string',
            'password'=>'required|string',
        ]);

            $credentials = $request->only('user_matricule', 'password');
            $token = Auth::attempt($credentials);
            if(!$token ){

            return response()->json([
                'status'=>'error',
                'message'=>'invalid user_matricule and password',
            ], 401);
        }

        $user = Auth::user();

        $cookies = Cookie::make('jwt', $token, 60 * 24);

         return response()->json([
            'status' => 'success',
            'message' => 'login successful',
            // "token" => $cookies,
            "token_type" => 'bearer',
            "data" => $user
         ])->withCookie($cookies);
        }



    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        Auth::logout();

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully signed out']);
    }


    // public function userProfile() {
    //     return response()->json(auth()->user());New_Query_1691587139195
    // }
    public function getusers(){

        $user = JWTAuth::parseToken()->authenticate();
        $user = User::paginate(10);

         return response()->json([
             'status' => 'success',
             'users' => $user,
            //  "role" => $user->roles()->get()->pluck(['title']),
         ]);
        }

    public function getusersbyid(Request $request, $id){
        $user = User::find($id);
        if (!$user ) {
            return response()->json([
                'status'=> 'error',
                'message' =>'user id  could not found',
            ], 404);
        }
       $data = [
        'user' => $user,
        'role' => $user->roles()->get()->pluck(['title']),
       ];

        return response()->json([
            'status' => 'success',
            'data'=> $data,
        ]);
    }

    public function updateusers(Request $request, $id){
        $user= User::Find($id);
        if(!$user) {
            return response()->json([
                'status'=> 'error',
                'message' =>'user id  could not found',
            ], 404);
        }

        $validatedData = $request->validate([
            'user_matricule' => 'required|string',
            'password'=>'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'profile_image'=> 'string',
            'phone' =>'numeric',
            'address' =>'string',
            'gender'=> 'string',
            'departments_id'=> 'integer',
            'positions_id'=> 'integer',


        ]);


               $user ->update([
               'user_matricule' => $validatedData['user_matricule'],
               'password' => ($validatedData['password']),
               'first_name' => $validatedData['first_name'],
               'last_name' => $validatedData['last_name'],
               'email' => $validatedData['email'],
               'profile_image' => $validatedData['profile_image'],
               'phone' => $validatedData['phone'],
               'address' => $validatedData['address'],
               'gender' => $validatedData['gender'],
               'departments_id'=> $validatedData[ 'departments_id'],
               'positions_id'=> $validatedData['positions_id'],
        ]);

        return response()->json([
            "status"=>"success",
            "message"=> "User successfully updated",
            "user" => $user,
            'role' => $user->roles()->get()->pluck(['title']),
        ]);

        }


        public function deleteuser(Request $request, $id){

            $user = User::Find($id);

            if (!$user ) {
                return response()->json([
                    "status"=> "not found",
                    "message"=> "user was not round"
                ], 404);
            }
                $user ->delete();

                return response()->json([
                    "status" => "success",
                    "message" => "user successfully deleted ",
                ]);





        }
// public function user(){
//     return 'Authenticated user';
// }
public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}

