<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\departmentController;
use App\Models\Access;
use App\Models\User;
use App\Models\Role;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\ImageStoreRequest;
use Symfony\Component\HttpFoundation\Response;





class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public $token = true;
    public function register( Request $request){

        $validatedData = $request->validate([
            'user_matricule' => 'required|string',
            'password'=>'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'profile_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'phone' =>'numeric',
            'address' =>'string',
            'gender'=> 'string',
            'departments_id'=> 'integer',
            'positions_id'=> 'integer',
            'is_manager' => 'boolean',

        ]);

        $fileName = time() . '.' .$request->profile_image->extension();
        $request->profile_image->storeAs('public/images', $fileName);

            $user= User::create([
                'user_matricule' => $validatedData['user_matricule'],
                'password' => ($validatedData['password']),
               'first_name' => $validatedData['first_name'],
               'last_name' => $validatedData['last_name'],
               'email' => $validatedData['email'],
               'profile_image'=>$fileName,
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
            // Response::HTTP_CREATED

         ]);
            }



    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, departmentController $id)
    {
        $validate = $request->validate([
            'user_matricule' => 'required|string',
            'password'=>'required|string',
        ]);

            $credentials = $request->only('user_matricule', 'password');
            $user = User::where('user_matricule', '=', $credentials['user_matricule'])->first();
            $rolePermissions = $user->roles()->get();
            $token = Auth::attempt($credentials, $rolePermissions);
            if(!$token ){

            return response()->json([
                'status'=>'error',
                'message'=>'invalid user_matricule and password',
            ], 401);
        }

        $user = Auth::user();
        $roles = $user->roles()->get()->pluck('title');
        $position = $user->position()->get()->pluck('title');
        $department = $user->department()->get()->pluck('title');
         $managers= (new departmentController)->getmanager($user->id);
        //  $managerData= $managers->get()->pluck($user->['profile_image','last_name','first_name']);

    $data = [
        'user' => $user,
        'role'=> $roles,
        'position' => $position,
        'department' => $department,
        'manager' => $managers,
    ];


    $customClaims= [
        'role' => $roles,
    ];

    $token = JWTAuth::claims($customClaims)->attempt($credentials);

         return response()->json([
            'status' => 'success',
            'message' => 'login successful',
            'token' => $token,
            'data' => $data,
         ]);
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
        $user = User::paginate(10);

        $data = [
            'user' => $user,
           ];
            // $roles = $user->roles()->get()->pluck('title');
            // $position = $user->position()->get()->pluck('title');
            // $department = $user->department()->get()->pluck('title');
            // $data = [
            //     'user' => $user,
            //     'roles' => $roles,
            //     'position' => $position,
            //     'department' => $department,
            //     // 'manager' => $managers,
            // ];




         return response()->json([
             'status' => 'success',
             'data' => $data,
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

       $roles = $user->roles()->get()->pluck('title');
        $position = $user->position()->get()->pluck('title');
        $department = $user->department()->get()->pluck('title');

        $data = [
            'user' => $user,
            'roles' => $roles,
            'position' => $position,
            'department' => $department,
            // 'manager' => $managers,
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
            'profile_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
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
           'profile_image'=> $validatedData['profile_image'] = $request->file('profile_image')->store('profile_image'),
           'phone' => $validatedData['phone'],
           'address' => $validatedData['address'],
           'gender' => $validatedData['gender'],
           'departments_id'=> $validatedData[ 'departments_id'],
           'positions_id'=> $validatedData['positions_id'],
           'is_manager' => $validatedData['is_manager'],

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

