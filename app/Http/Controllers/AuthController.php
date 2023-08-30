<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\departmentController;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Access;
use App\Models\Kpi;
use App\Models\User;
use App\Models\Role;
use App\Models\Position;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;



class AuthController extends Controller
{
    // public $token = true;
    protected $userRepository;
    protected $user;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function register(UserStoreRequest $request) {
        $userData = $request->validated();
        $user = $this->userRepository->createUser($userData);

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time(). '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/images/' . $fileName);
            $user->profile_image = $filePath;
        }
        $user->role()->attach($userData['role_id']);
        $user->profile_image = config('app.url') . "/storage/" . $user->profile_image;
        return ResponseBuilder::success($user, 201);
    }


    public function getUserById($id) {
        $user = $this->userRepository->getUserById($id);
        $roles = $user->role->pluck('title');
        $position = $user->position->title;
        $user->profile_image = config('app.url') . "/storage/" . $user->profile_image;
        $departmentManagerID = $user->department->title;
        $managerData = collect($user->lineManager)->only('first_name', 'last_name', 'profile_image');
        $user['profile_image']= config('app.url') . "/storage/" . $user->lineManager->profile_image;
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

    public function UpdateUserDetails( $id, UserUpdateRequest $request)
    {
        // $userData = $request->validated();
        $filePath = null;
        $user = $this->userRepository->updateUser($id, $request->all());
        if ($request->hasFile('profile_image'))
        {
            $file = $request->file('profile_image');
            $fileName = time(). '_' . $file->getClientOriginalName();
            $filePath = $file->move('public/images/' . $fileName);
            $user->profile_image = $filePath;
        }
        $user->save();
        $user->role()->attach($user['role_id']);
        $userArray = $user->toArray();
        $userArray['profile_image'] = $filePath ? config('app.url') . "/storage/": null;
        return ResponseBuilder::success($userArray,200);
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
        if(!$token = auth::attempt($credentials) )
        {
            return ResponseBuilder::error(404);
        }
        $user = Auth::user();
        $managerData = collect($user->linemanager)->only('first_name', 'last_name', 'profile_image');
        $data =
        [
            'user' => $user,
            'token' => $token,
            'role'=> $user->role->pluck('title'),
            'position' => $user->position->title,
            'department'=> $user->department->title,
            'manager'=> $managerData,
        ];
        $managerData['profile_image']= config('app.url') . "/storage/" . $user->profile_image;
        $user->profile_image = config('app.url') . '/storage/' . $user->profile_image;
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
