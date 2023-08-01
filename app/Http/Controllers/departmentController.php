<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class departmentController extends Controller
{


    // manager endpoints

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
    public function getdepartments(){
        $department  = Department::all();
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
}
