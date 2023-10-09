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
use Exception;
use Illuminate\Http\JsonResponse;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        // $this->middleware('jwt.auth')->except('login');
        // $this->middleware('permission:user create')->only('register');
        // $this->middleware('permission:user delete')->only('deleteUser');
        // $this->middleware('permission:user edit')->only('updateUserDetails');
        // $this->middleware('permission:user list')->only('getAllUsers');
        // $this->middleware('permission:direct reports list')->only('getAllDirectReportsByUserId','getAllDirectReportsForUser');
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->all();
        if(!$token = JWTAuth::attempt($credentials) )
        {
            return ResponseBuilder::error(400,[''],['Invalid Credentials'],);
        }
        $user = Auth::user();
        $expiration = JWTAuth::factory()->getTTL()*60;
        $user->position;
        $user->department;
        $user->lineManager;
        $user->roles;
        $data =
        [
            'user' => $user,
            'token' => $token,
            'expiration' => $expiration,
        ];
        return ResponseBuilder::success($data, 200);
    }
    public function register(UserStoreRequest $request) {
        if(!$request->validated()){
            return ResponseBuilder::error(400);
        }
        $user = $this->userRepository->createUser($request->all());
        $this->storeProfileImage($user, $request);
        $user->profile_image = $this->getImageUrl($user->profile_image);
        $userArray = $user->toArray();
        if ($user->line_manager === null) {
            $department = Department::find($user->departments_id);
            $user->line_manager = $department->manager_id;
        }
        $roles = $request->input('roles');
        if (is_array($roles)) {
            foreach ($roles as $role) {
                $user->assignRole($role);
            }
        } else {
            $user->assignRole($roles);
        }
        $user->save();
        return ResponseBuilder::success($userArray,201,null,201);
    }
    public function getUserById($id, Exception $e)
     {
        $userData = $this->userRepository->getUserById($id, $e);
        $userData =[ 'user'=> $userData];
        return ResponseBuilder::success($userData,200);
    }
    public function getAllUsers(Request $request)
    {
        $user = Auth::user();
        $users = $this->userRepository->getUsers($request);
        return ResponseBuilder::success($users,200);
    }

    public function updateUserDetails( $id, UserUpdateRequest $request, Exception $e)
    {
        $user = $this->userRepository->updateUser($id,$request->all(), $e);
        $filePath = $this->storeProfileImage($user, $request);
        if(!empty($filePath)){
        $user->profile_image = $this->getImageUrl($user->profile_image);
        }
        $userArray = $user->toArray();
        $roles = $request->input('roles');
        if (is_array($roles)) {
            foreach ($roles as $role) {
                $user->assignRole($role);
            }
        } else {
            $user->assignRole($roles);
        }
        $user->save();
        return ResponseBuilder::success($userArray,200);
    }
    public function deleteUser($id ,Exception $e)
    {
       $user = $this->userRepository->deleteUser($id, $e);
        return ResponseBuilder::success(204,null,null,204);
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

    public function getAllDirectReportsByUserId($id, Exception $e)
    {
        $kpis = $this->userRepository->getAllDirectReportsById($id, $e);
        return ResponseBuilder::success($kpis, 200);
    }
    public function storeProfileImage($user, $request)
    {
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time(). '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('/public/images/' . $fileName);
            $user->profile_image = 'images/'.$fileName;
            return $filePath;
        }
        return '';
    }
     public function getImageUrl($Path)
     {
        return config('app.url') . "/storage/" . $Path;
     }
  }
