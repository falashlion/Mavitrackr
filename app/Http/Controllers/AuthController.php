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
use Illuminate\Http\JsonResponse;

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
        $roles = $this->roles()->only('title');
        $position = $user->position()->only('title');
        $department = $user->department()->only('title');
        $managerData = $user->department->manager->only('first_name', 'id', 'last_name', 'profile_image');

        $data = [
            'user' => $user,
            'role'=> $roles,
            'position' => $position,
            'department' => $department,
            'manager'=> $managerData,

        ];
        return response()->json(['data' => $data]);
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
        $user = Auth::user();
        // $roles = $user->roles->pluck('title');
        // $position = $user->position->title;
        // $departmentManagerID = $user->department->title;
        // $managerData = $user->department->manager->id;
        // $departmentManager=[$departmentManagerID];

    $data = [
        'user' => $user,
        // 'role'=> $roles,
        // 'position' => $position,
        // 'department'=> $departmentManager,

    ];
        return response()->json(['users' => $users]);
    }


    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, departmentController $id)
    {
        $credentials = $request->validated();

        if(!$token = Auth::attempt($credentials) ){

            return response()->json([
                'status'=>'error',
                'message'=>'invalid user_matricule and password',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        // $roles = $user->roles->pluck('title');
        $position = $user->position->title;
        $departmentManagerID = $user->department->title;
        $managerData = $user->department->manager->id;
        $departmentManager=[$departmentManagerID];

    $data = [
        'user' => $user,
        'roles'=> $user->roles->pluck('title'),
        // 'position' => $position,
        'department'=> $departmentManager,

    ];


    $customClaims= [
        // 'role' => $roles,
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
