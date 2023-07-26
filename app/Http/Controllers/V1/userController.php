<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class userController extends Controller
{

    /*public function __construct(){
        $this->middleware('auth:api');
    }
    */
    public function index(){
       $users = users::all();
        return response()->json([
            'status' => 'success',
            'users' => $users,
        ]);
       // $users = DB::table('users')->paginate(10);
        //return view('users.index', ['users' => $users]);
    }
    public function register(Request $request){
        try {
            $users= new users();
            $users-> first_name = $request->input('first_name');
            $users->last_name = $request->input('last_name');
            $users->email = $request->input('email');
            $users->user_matricule = $request-> input('user_matricule');
            $users->password = Hash::make($request->input('password'));
            $users-> profile_image = $request-> input('profile_image');
            $users-> phone_number = $request-> input('phone_number');
            $users-> address = $request-> input('address');
            $users-> gender = $request-> input('gender');

            $users->save();
            $token = JWTAuth::fromUser($users);

        return response()->json(['token' => $token], 201);
    }
     catch (\Exception $e) {
        return response()->json(['error' => 'Failed to register user'], 400);
    }
        }

    public function show(){

            }

    public function update(){

                }
    public function destroy(){
        }

}
