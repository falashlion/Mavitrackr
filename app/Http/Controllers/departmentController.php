<?php

namespace App\Http\Controllers;

use App\Models\departments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class departmentController extends Controller
{
    public function getdepartments(){
        $department  = departments::all();
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
            $department = departments::insert([
                "title"   =>  $validatedData['title'],
            ]);
        }
        public function updatedepartments(Request $request, $id){

            $departments = departments::Find($id);
            if(!$departments) {
                return response()->json([
                    'status'=> 'error',
                    'message' =>'department could not found',
                ], 404);
            }

            $validatedData = $request-> validate([
                'title' => 'required|string'
                ]);
                dd($validatedData);
                $departments->update([
                    "title"=> $validatedData["title"],
                ]) ;
                return response() -> json ([
                    "status"=>"updated",
                    "message"=> "department updated",
                ]);

        }

        public function deletedepartments(Request $request, $id){

            $departments = departments::Find($id);



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
