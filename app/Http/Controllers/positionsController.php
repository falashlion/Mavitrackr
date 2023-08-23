<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Http\Controllers\Controller;
class positionsController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth.role');
    // }
      public function getpositions(){
        $position  = Position::all();
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
            $position = Position::insert([
                "title"   =>  $validatedData['title'],
            ]);
            return response ()-> json ( [
                "status"    =>"success",
                "data"      => $position,
                "Message"   =>"job title  created successfully."], JsonResponse::HTTP_OK);
        }
        public function updatepositions(Request $request, $id){

            $positions = Position::Find($id);
            if(!$positions) {
                return response()->json([
                    'status'=> 'error',
                    'message' =>'positions could not found',
                ], 404);
            }

            $validatedData = $request-> validate([
                'title' => 'required|string'
                ]);
               // dd($validatedData);
                $positions->update([
                    "title"=> $validatedData["title"],
                ]) ;
                return response() -> json ([
                    "status"=>"updated",
                    "message"=> "position updated",
                ], JsonResponse::HTTP_OK);

        }

        public function deletepositions(Request $request, $id){

            $position = Position::Find($id);



            if (!$position ) {
                return response()->json([
                    "status"=> "Not found",
                    "message"=> "position was not round"
                ], 404);
            }
                $position ->delete();

                return response()->json([
                    "status" => "sucess",
                    "message" => "position successfully deleted ",
                ], JsonResponse::HTTP_OK);

        }
        public function getpositionsbyid(Request $request, $id){

            $position= Position::Find($id);
        if (!$position ) {
            return response()->json([
                'status'=> 'error',
                'message' =>'job title id could not found',
            ], JsonResponse::HTTP_NOT_FOUND);
        }
        $position -> get();
        return response()->json([
            "status" => "success",
            "data"=> $position,
        ], JsonResponse::HTTP_OK);

        }
}
