<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\interfaces\UserRepositoryInterface;
use App\Models\Department;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException as Exception;
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
     * instatiates the userRepository,jwt auth and spaties permissions classes in the controller.
     * through the interfaces
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('jwt.auth')->except('login');
        // $this->middleware('permission:user create')->only('register');
        // $this->middleware('permission:user delete')->only('deleteUser');
        // $this->middleware('permission:user edit')->only('updateUserDetails');
        // $this->middleware('permission:user list')->only('getAllUsers');
        // $this->middleware('permission:direct reports list')->only('getAllDirectReportsByUserId','getAllDirectReportsForUser');
    }
    /**
     * login
     *
     * @param  LoginRequest $request login credetials passed in the request body
     * @return Response the object of the user's information is returned
     * @throws Exception If the user's credentials are invalid.
     * This method logs in the user by checking the user's credentials against the database. If the user's credentials are valid, the method returns an object containing the user's information.
     * If the user's credentials are invalid, the method throws an exception.
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
     * Register method.
     *
     * @param  UserStoreRequest $request data required to create a new user passed in the body of the request.
     * @throws Exception If the request is not validated.
     * @return Response the object of the user's information is returned
     * This method creates a new user by validating the request and creating a new user in the database.
     * If the request is not validated, the method throws an exception.
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
     * This method retrieves a user's information by their ID.
     *
     * @param  string $id The user's ID passed in the URL
     * @return Response The object of the user's information is returned
     */
    public function getUserById(string $id)
     {
        $userData = $this->userRepository->getUserById($id);
        $userData =[ 'user'=> $userData];

        return ResponseBuilder::success($userData,200);
    }
    /**
     * getAllUsers
     * the value to paginate the users with
     * This method retrieves all users' information from the database.
     * @return Response The object containing all users' information is returned.
     */
    public function getAllUsers(Request $request)
    {
        $users = $this->userRepository->getUsers($request);

        return ResponseBuilder::success($users,200);
    }

    /**
     * updateUserDetails
     *
     * @param  string $id The user's ID.
     * @param  UserUpdateRequest $request The object of user data to be updated.
     * @return Response user object
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
     * @param  string $id The user's ID.
     * @return Response This returns no content
     */
    public function deleteUser($id)
    {
       $user = $this->userRepository->deleteUser($id);

        return ResponseBuilder::success(204,null,null,204);
    }
    /**
     * logout
     *
     * @return Response object indicating successfull logout
     * This method logs out the user from the application.
     */
    public function logout()
    {
        Auth::logout();

        return ResponseBuilder::success(200 );
    }
    /**
    *Get all direct reports for authenticated user.
    *@return Response The object containing all direct reports' information is returned.
    *This method retrieves all direct reports' information for a user from the database.
    */
    public function getAllDirectReportsForUser()
    {
        $kpis = $this->userRepository->getAllDirectReports();

        return ResponseBuilder::success($kpis, 200);
    }

    /**
     * getAllDirectReportsByUserId
     *
     * @param  string $id The user's ID.
     * @return Response The object containing all direct reports' information is returned.
     * This method retrieves all direct reports' information for a user by their ID from the database.
     */
    public function getAllDirectReportsByUserId($id)
    {
        $kpis = $this->userRepository->getAllDirectReportsById($id);

        return ResponseBuilder::success($kpis, 200);
    }
    /**
     * storeProfileImage
     *
     * @param  object $user The user object.
     * @param  object $request The user object parameters caring the image
     * @return string The path of the image.
     *
     * This method stores the user's profile image to the database.
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
      *
      * This method retrieves the image URL with the AWS URL attached.
      */
     public function getImageUrl($Path)
     {
        return env('AWS_URL').$Path;
     }
  }
