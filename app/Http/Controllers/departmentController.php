<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;


class departmentController extends Controller
{


    // manager endpoints

    // public function __construct()
    // {
    //     $this->middleware('auth.role');
    // }

    public function getmanagerbyid(Request $request, $id){

        $managerdata = Department::with('User:first_name,last_name,profile_image')->get();
        $department= Department::Find($id);
        if (!$department ) {
            return response()->json([
                'status'=> 'error',
                'message' =>'department could not found',
            ], 404);
        }
        $manager = $department->where('is_manager', true)->first();

        if(!$manager) {
            return response()->json([
                "status" => "error",
                "message" => "No manager found for this department"
            ]);
        }
        if ($manager->id != $request->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'you are not authorized to access this resource',
            ], 403);
        }

        $department -> get();
        return response()->json([
            "status" => "success",
            "data"=>$managerdata ,
        ]);
    }

    // public function managerResponse(User $user){
    //     $managerdata = $user->with('first_name', 'last_name', 'profile_image');
    // }

    public function getdepartmentsbyid(Request $request, $id){
        $department= Department::Find($id);
        if (!$department ) {
            return response()->json([
                'status'=> 'error',
                'message' =>'department could not found',
            ], 404);
        }
        $department -> get();
        return response()->json([
            "status" => "success",
            "data"=> $department,
        ]);
    }
    public function getdepartments(Request $request){
        $department  = Department::paginate(10);
         return response()->json([
             'status' => 'success',
             'users' => $department,
         ]);
        }

        public function createdepartments(Request $request){
            $validatedData = $request-> validate([
            'title' => 'required|string'
            ]);

            //dd($validatedData);
            $department = Department::insert([
                "title"   =>  $validatedData['title'],
            ]);
            return response ()-> json ( [
                "status"    =>"success",
                "data"      =>$department,
                "Message"   =>"Department created successfully."]);

        }
        public function updatedepartments(Request $request, $id){

            $departments = Department::Find($id);
            if(!$departments) {
                return response()->json([
                    'status'=> 'error',
                    'message' =>'department could not found',
                ], 404);
            }

            $validatedData = $request-> validate([
                'title' => 'required|string'
                ]);
                //dd($validatedData);
                $departments->update([
                    "title"=> $validatedData["title"],
                ]) ;
                return response() -> json ([
                    "status"=>"updated",
                    "message"=> "department updated",
                ]);

        }

        public function deletedepartments(Request $request, $id){

            $departments = Department::Find($id);



            if (!$departments ) {
                return response()->json([
                    "status"=> "notfound",
                    "message"=> "department was not round"
                ], 404);
            }
                $departments ->delete();

                return response()->json([
                    "status" => "success",
                    "message" => "department successfully deleted ",
                ]);

        }
        // endpoints for manager data

        public function getmanager(Request $request, $id){

            $user = User::find($id);


            if(!$user){
                return response ()-> json ( [
                    "status" => 'error',
                    "message" => ' user not found']);
                }

            $manager = User::select("*")//"first_name", "last_name", "profile_image")
            ->where([
                ['is_manager',"=", true,],
                ['departments_id' ,"=", $user->departments_id]
            ])->get();

            if(!$manager){
                return response ()-> json ( [
                    "status" => 'error',
                    "message" =>' department not found' ] );
            }

            return response()->json([
                "status"=>"success",
                "data"=>$manager,

            ]);

        }

        public function getdirectreports(Request $request, $id){

            // $user = JWTAuth::parseToken()->authenticate();
            $user=User::find($id) ;
            if(!$user){
                return response ()-> json ( [
                    "status" => 'error',
                    "message" => ' user not found']);
                }

            $manager = User::select("*")
            ->where([
                ['is_manager',"=", false,],
                ['departments_id' ,"=", $user->departments_id]
            ])->get();

            if(!$manager){
                return response ()-> json ( [
                    "status" => 'error',
                    "message" =>' department not found' ] );
            }

            return response()->json([
                "status"=>"success",
                "data"=>$manager,

            ]);
        }
}
