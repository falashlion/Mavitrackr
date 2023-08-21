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
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;







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
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request) {
        $user = $this->userRepository->createUser($request->all());
        return response()->json(['user' => $user]);
    }

    public function getUserById($id) {
        $user = $this->userRepository->getUserById($id);
        return response()->json(['user' => $user]);
    }

    public function updateUser($id, Request $request) {
        $user = $this->userRepository->updateUser($id, $request->all());
        return response()->json(['user' => $user]);
    }

    public function deleteUser($id) {
        $this->userRepository->deleteUser($id);
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function getUsers() {
        $users = $this->userRepository->getAllUsers();
        return response()->json(['users' => $users]);
    }


    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, departmentController $id)
    {
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



    $data = [
        'user' => $user,
        'role'=> $roles,
        'position' => $position,
        'department' => $department,

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


  }
