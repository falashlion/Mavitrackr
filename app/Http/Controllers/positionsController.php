<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class positionsController extends Controller
{
     /*  public function getpositions(){
        $position  = positions::all();
         return response()->json([
             'status' => 'success',
             'users' => $department,
         ]);
        }

        public function createpositions(Request $request){
            $validatedData = $request-> validate([
            'title' => 'required|string'
            ]);

            dd($validatedData);
            $department = departments::create([
                "title"   =>  $validatedData['title'],
            ]);
        }
        public function updatepositions(Request $request, $id){

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

        public function deletepositions(Request $request, $id){

            $departments = departments::Find($id);



            if (!$departments ) {
                return response()->json([
                    "status"=> "notfound",
                    "message"=> "department was not round"
                ], 404);
            }
                $departments ->delete();

                return response()->json([
                    "status" => "sucess",
                    "message" => "department successfully deleted ",
                ]);





        }*/
}
