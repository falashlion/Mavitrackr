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
use Illuminate\Support\Facades\Storage;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;



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
    }

    public function register(UserStoreRequest $request) {
        $user = $request->validated();
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time(). '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('images/' . $fileName);
            Storage::putFile($filePath, $file);
            $user->profile_image = $filePath;
            $user->save();
        }
        $user = $user->userRepository->createUser();
        return ResponseBuilder::success($user,201);
    }

    public function getUserById($id) {
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
    return ResponseBuilder::success($data,200);
    }

    public function updateUser( $id, Request $request)
    {
        $user = $this->userRepository->updateUser($id, $request->all());
        return ResponseBuilder::success($user,200);
    }

    public function deleteUser($id)
    {
        $this->userRepository->deleteUser($id);
        return ResponseBuilder::success(200);
    }

    public function getUsers(Request $request)
    {
        $users = $this->userRepository->getAllUsers($request);
        return ResponseBuilder::success($users,200);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if(!$token = auth('api')->attempt($credentials) )
        {
            return ResponseBuilder::error(404);
        }
        $user = Auth::user();
        $data =
        [
            'user' => $user,
            'token' => $token,
            'role'=> $user->roles->pluck('title'),
            'position' => $user->position->title,
            'department'=> $user->department->title,
            'manager'=> collect($user->department->manager)->only('first_name', 'last_name', 'profile_image'),
        ];
        return ResponseBuilder::success($data, 200 );
    }
    public function logout()
    {
        Auth::logout();

        return ResponseBuilder::success(200 );
    }
     // function for all the members in a department
    public function getDepartmentMembers($id)
    {
        $users = $this->userRepository->getDepartmentMembers($id);
        $data =
        [
            'users' => $users,
        ];
        return ResponseBuilder::success($data, 200 );
    }


  }
