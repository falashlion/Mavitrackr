<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\position;
use App\Http\Controllers\Controller;
class positionsController extends Controller
{
      public function getpositions(){
        $position  = position::all();
         return response()->json([
             'status' => 'success',
             'users' => $position,
         ]);
        }

        public function createpositions(Request $request){
            $validatedData = $request-> validate([
            'title' => 'required|string'
            ]);

            //dd($validatedData);
            $position = position::insert([
                "title"   =>  $validatedData['title'],
            ]);
        }
        public function updatepositions(Request $request, $id){

            $positions = position::Find($id);
            if(!$positions) {
                return response()->json([
                    'status'=> 'error',
                    'message' =>'positions could not found',
                ], 404);
            }

            $validatedData = $request-> validate([
                'title' => 'required|string'
                ]);
                dd($validatedData);
                $positions->update([
                    "title"=> $validatedData["title"],
                ]) ;
                return response() -> json ([
                    "status"=>"updated",
                    "message"=> "position updated",
                ]);

        }

        public function deletepositions(Request $request, $id){

            $position = position::Find($id);



            if (!$position ) {
                return response()->json([
                    "status"=> "Notfound",
                    "message"=> "position was not round"
                ], 404);
            }
                $position ->delete();

                return response()->json([
                    "status" => "sucess",
                    "message" => "position successfully deleted ",
                ]);





        }
}