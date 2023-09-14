<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\interfaces\UserRepositoryInterface;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\LoginRequest;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('jwt.auth')->except('login');
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if(!$token = JWTAuth::attempt($credentials) )
        {
            return ResponseBuilder::error(401);
        }
        $user = Auth::user();
        $expiration = JWTAuth::factory()->getTTL()*60;
        $user->position;
        $user->department;
        $user->lineManager;
        $data =
        [
            'user' => $user,
            'token' => $token,
            'expiration' => $expiration,
        ];
        return ResponseBuilder::success($data, 200);
    }

    public function register(UserStoreRequest $request) {
        $user = $this->userRepository->createUser($request->all());
        $this->storeProfileImage($user, $request);
        $user->profile_image = config('app.url') . "/storage/" . $user->profile_image;
        $userArray = $user->toArray();
        if ($user->line_manager === null) {
            $department = Department::find($user->departments_id);
            $user->line_manager = $department->manager_id;
        }
        $user->assignRole($request->input('roles'));
        $user->save();
        return ResponseBuilder::success($userArray, 201);
    }
    public function getUserById($id)
     {
        $userData = $this->userRepository->getUserById($id);
        $userData = [
            'user'=> $userData
        ];
        return ResponseBuilder::success($userData,200);
    }
    public function getAllUsers(Request $request)
    {
        $user = Auth::user();
        $users = $this->userRepository->getUsers($request);
        return ResponseBuilder::success($users,200);
    }

    public function updateUserDetails( $id, UserUpdateRequest $request)
    {
        $user = $this->userRepository->updateUser($id, $request->all());
        $this->storeProfileImage($user, $request);
        $user->profile_image = $this-> getImageUrl($user->profile_image);
        $userArray = $user->toArray();
        $user->syncRole($request->input('roles'));
        $user->save();
        return ResponseBuilder::success($userArray,200);
    }
    public function deleteUser($id)
    {
        $this->userRepository->deleteUser($id);
        return ResponseBuilder::success(204);
    }
    public function logout()
    {
        Auth::logout();
        return ResponseBuilder::success(200 );
    }
    public function getAllDirectReportsForUser()
    {
    $kpis = $this->userRepository->getAllDirectReports();
    return ResponseBuilder::success($kpis, 200);
    }
    public function storeProfileImage($user, $request)
    {
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time(). '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('/public/images/' . $fileName);
            $user->profile_image = 'images/'.$fileName;
        }
    }
     public function getImageUrl($Path)
     {
        return config('app.url') . "/storage/" . $Path;
     }
  }
