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
    protected $user;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('api', ['except' => ['login']]);



    }

    public function register(Request $request) {
        $user = $this->userRepository->createUser($request->all());
        return response()->json(['user' => $user],JsonResponse::HTTP_OK);
    }

    public function getUserById($id) {
        $auth=Auth::guard('api')->user();
        dd($auth);
        $user = $this->userRepository->getUserById($id);
        $roles = $user->roles->pluck('title');
        $position = $user->position->title;
        $departmentManagerID = $user->department->title;
        $managerData = $user->department->manager->only('first_name', 'last_name', 'profile_image');


    $data =
    [
        'user' => $user,
        'role'=> $roles,
        'position' => $position,
        'department'=> $departmentManagerID,
        'manager'=> $managerData,

    ];
        return response()->json(['data' => $data],JsonResponse::HTTP_OK);
    }

    public function updateUser( $id, Request $request)
    {
        $user = $this->userRepository->updateUser($id, $request->all());
        return response()->json(
        [
            'user' => $user
        ],JsonResponse::HTTP_OK);
    }

    public function deleteUser($id) {
        $this->userRepository->deleteUser($id);
        return response()->json(['message' => 'User deleted successfully'],JsonResponse::HTTP_OK);
    }

    public function getUsers(Request $request) {
        $users = $this->userRepository->getAllUsers();

    $data = [
        'users' => $users,
    ];
        return response()->json(['data' => $data],JsonResponse::HTTP_OK);
    }


    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */


    public function login(LoginRequest $request, departmentController $id)
    {
        $credentials = $request->validated();

        if(!$token = auth('api')->attempt($credentials) ){

            return response()->json([
                'status'=>'error',
                'message'=>'invalid user_matricule and password',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        $data = [
            'user' => $user,
            'role'=> $user->roles->pluck('title'),
            'position' => $user->position->title,
            'department'=> $user->department->title,
            'manager'=> $user->department->manager->only('first_name', 'last_name', 'profile_image'),

        ];

        return response()->json([
        'status' => 'success',
        'message' => 'login successful',
        'token' => $token,
        'data' => $data,
        //










        'expires_in' => auth()->factory()->getTTL() * 60
        ], JsonResponse::HTTP_OK);
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
            'message' => 'User successfully signed out'],JsonResponse::HTTP_OK);
    }

     // function for all the members in a department

     public function getDepartmentMembers($id)
     {
        $users = $this->userRepository->getDepartmentMembers($id);
        $data = [
            'users' => $users,
        ];
            return response()->json(['data' => $data],JsonResponse::HTTP_OK);

     }


  }
