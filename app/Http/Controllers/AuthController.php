<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;
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
        $userData = $this->userRepository->getUserById($id);
        $userData->profile_image = config('app.url') . "/storage/" . $userData->profile_image;
        $data =
            [
                'user' => $userData,
                'role'=> $userData->roles,
                'position' => $userData->position->title,
                'department'=> $userData->department->title,
                'manager'=> collect($userData->lineManager)->only('first_name', 'last_name', 'profile_image'),
                'kpis'=> $userData->kpis
            ];

        return ResponseBuilder::success($data,200);
    }

    public function UpdateUserDetails( $id, UserUpdateRequest $request)
    {
        // $filePath = null;
        $user = $this->userRepository->updateUser($id, $request->all());
        if ($request->hasFile('profile_image'))
        {
            $file = $request->file('profile_image');
            $fileName = time(). '_' . $file->getClientOriginalName();
            $filePath = $file->move('public/images/' . $fileName);
            $user->profile_image = $filePath;
        }
        $userArray = $user->toArray();
        $user->roles()->attach($user['role_id']);
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
        $user = Auth::user();
        $users = $this->userRepository->getAllUsers($request);
        return ResponseBuilder::success($users,200);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if(!$token = Auth::attempt($credentials) )
        {
            return ResponseBuilder::error(401);
        }
        $user = Auth::user();
        $data =
        [
            'user' => $user,
            'token' => $token,
            'role'=> $user->roles,
            'position' => $user->position->title,
            'department'=> $user->department->title,
            'manager'=> collect($user->linemanager)->only('first_name', 'last_name', 'profile_image'),
        ];
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
