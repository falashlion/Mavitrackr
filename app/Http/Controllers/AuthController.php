<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator;
// use Tymon\JWTAuth\Exceptions\JWTException;
// use Tymon\JWTAuth\Facades\JWTAuth;
//use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
   public function __construct() {
       $this->middleware('auth:api', ['except' => ['login', 'register', 'getusers', 'getdepartments', 'createdepartments', 'updatedepartments', 'deletedepartments', 'getusersbyid']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public $token = true;
    public function register(Request $request){

        $validatedData = $request->validate([
            'user_matricule' => 'required|string',
            'Password'=>'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'profile_image'=> 'string',
            'phone' =>'numeric',
            'address' =>'string',
            'gender'=> 'string',
            //'department_id'=> 'string',
            //'job_title_id'=> 'numeric',
            //'date_of_birth'=>'numeric'
        ]);

        //dd($validatedData);
            $user= User::insert([
                'user_matricule' => $validatedData['user_matricule'],
                'Password' => Hash::make($validatedData['Password']),
               'first_name' => $validatedData['first_name'],
               'last_name' => $validatedData['last_name'],
               'email' => $validatedData['email'],
               'profile_image' => $validatedData['profile_image'],
               'phone' => $validatedData['phone'],
               'address' => $validatedData['address'],
               'gender' => $validatedData['gender'],
                // 'department_id'=> $validatedData['department_id'],
                // 'job_title_id'=> $validatedData['job_title_id'],
                //'date_of_birth' => $validatedData['date_of_birth'],

        ]);

        // if ($this->token){
        //     return $this->login($request);
        //}
         return response()->json([
            'status'=> 'success',
            'message'=> 'user successfully created',
            'user'=> $user,

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
            'Password'=>'required|string',
            // 'email' => 'string',
        ]);
        //dd(auth('api')->attempt($validate));
        // if(!$JWT_token = auth('api')->attempt($validate)){
            //dd($validate);
            $credentials = $request->only('user_matricule', 'Password');
            //$JWT_token = $validate->createToken()->JWTToken();

            if(!$JWT_token = Auth::attempt($credentials)){

            return response()->json([
                'status'=>'error',
                'message'=>'invalid user_matricule and password',
            ], 401);
        }

        //dd($JWT_token);die;
         return response()->json([
            "status" => 'success',
            "token" => $JWT_token,
         ]);





     }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {

        return response()->json(['message' => 'User successfully signed out']);
    }


    public function userProfile() {
        return response()->json(auth()->user());
    }
    public function getusers(){
        $user = User::all();
         return response()->json([
             'status' => 'success',
             'users' => $user,
         ]);
        }

    public function getusersbyid(Request $request, $id){
        $user= User::Find($id);
        if (!$user ) {
            return response()->json([
                'status'=> 'error',
                'message' =>'user id  could not found',
            ], 404);
        }
        $user = User::get();
        return response()->json([
            "status" => "success",
            "data"=> $user,
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
            'Password'=>'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'profile_image'=> 'string',
            'phone' =>'numeric',
            'address' =>'string',
            'gender'=> 'string',
            'department_id'=> 'string',
            'job_title_id'=> 'numeric',
            'date_of_birth'=>'numeric',

        ]);

        //dd($validatedData);
                 $user ->update([
                'user_matricule' => $validatedData['user_matricule'],
                'Password' => Hash::make($validatedData['Password']),
               'first_name' => $validatedData['first_name'],
               'last_name' => $validatedData['last_name'],
               'email' => $validatedData['email'],
               'profile_image' => $validatedData['profile_image'],
               'phone' => $validatedData['phone'],
               'address' => $validatedData['address'],
               'gender' => $validatedData['gender'],
                'department_id'=> $validatedData['department_id'],
                'job_title_id'=> $validatedData['job_title_id'],
                'date_of_birth' => $validatedData['date_of_birth'],
        ]);

        return response()->json([
            "status"=>"success",
            "message"=> "User successfully updated",
            "user" => $user,
        ]);

        }


        // password reset endpoints


}

