<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\interfaces\UserRepositoryInterface;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Storage;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $userRepository;

    /**
     * __construct
     *
     * @param  object $userRepository
     * creates the connection between the controller and the repository the
     * through the interfaces
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('jwt.auth')->except('login','getAllUsers');
        // $this->middleware('permission:user create')->only('register');
        // $this->middleware('permission:user delete')->only('deleteUser');
        // $this->middleware('permission:user edit')->only('updateUserDetails');
        // $this->middleware('permission:user list')->only('getAllUsers');
        // $this->middleware('permission:direct reports list')->only('getAllDirectReportsByUserId','getAllDirectReportsForUser');
    }
    /**
     * login
     *
     * @param  object $request login credetials passed in the request body
     * @return object the object of the user's information is returned
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->all();
        if(!$token = JWTAuth::attempt($credentials) )
        {
            return ResponseBuilder::error(400,null,['Invalid username or password'],400);
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
    /**
     * register
     *
     * @param  object $request data required to create a new user passed in the body of the request.
     *
     * @return object the object of the user's information is returned
     */
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
    /**
     * getAUserByTheirId
     *
     * @param  string $id the user's id passed in the url
     * @return object the object of the user's information is returned
     */
    public function getUserById($id)
     {
        $userData = $this->userRepository->getUserById($id);
        $userData =[ 'user'=> $userData];

        return ResponseBuilder::success($userData,200);
    }
    /**
     * getAllUsers
     *
     * @param  object $request
     * @return object
     */
    public function getAllUsers()
    {
        $users = $this->userRepository->getUsers();

        return ResponseBuilder::success($users,200);
    }

    /**
     * updateUserDetails
     *
     * @param  string $id user's id
     * @param  object $request object of user data
     * @return object user object
     * updates a particular user in the mavitrackr application
     */
    public function updateUserDetails( $id, UserUpdateRequest $request)
    {
        $user = $this->userRepository->updateUser($id,$request->all());
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
    /**
     * deleteUser
     *
     * @param  string $id
     * @return object
     */
    public function deleteUser($id)
    {
       $user = $this->userRepository->deleteUser($id);

        return ResponseBuilder::success(204,null,null,204);
    }
    /**
     * logout
     *
     * @return object
     */
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

    /**
     * getAllDirectReportsByUserId
     *
     * @param  string $id
     * @return object
     */
    public function getAllDirectReportsByUserId($id)
    {
        $kpis = $this->userRepository->getAllDirectReportsById($id);

        return ResponseBuilder::success($kpis, 200);
    }
    /**
     * storeProfileImage
     *
     * @param  object $user
     * @param  object $request user object parameters
     * @return string it returns the path of the image
     * @implements
     */
    public function storeProfileImage($user, $request)
    {
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time(). '_' . $file->getClientOriginalName();
            $filePath = 'images/' . $fileName;
            $path = Storage::disk('s3')->put($filePath,file_get_contents($file));
            $user->profile_image = $filePath;
            return $fileName;
        }

        return '';
    }
     /**
      * getImageUrl
      *
      * @param  string $Path the image path
      * @return string Returns the image url with the aws url attached
      */
     public function getImageUrl($Path)
     {
        return env('AWS_URL').$Path;
     }
  }
