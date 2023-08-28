<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Http\Controllers\Controller;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
class positionsController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth.role');
    // }
      public function getpositions(){
        $position  = Position::all();
        return ResponseBuilder::success($position, 200 );
        }

        public function createpositions(Request $request){
            $validatedData = $request-> validate([
            'title' => 'required|string'
            ]);
            $position = Position::insert([
                "title"   =>  $validatedData['title'],
            ]);
            return ResponseBuilder::success($position, 200 );
        }
        public function updatepositions(Request $request, $id){

            $positions = Position::Find($id);
            if(!$positions) {
                return ResponseBuilder::success(400);
            }

            $validatedData = $request-> validate([
                'title' => 'required|string'
                ]);
                $positions->update([
                    "title"=> $validatedData["title"],
                ]) ;
                return ResponseBuilder::success($positions, 200 );

        }

        public function deletepositions(Request $request, $id){

            $position = Position::Find($id);



            if (!$position ) {
                return ResponseBuilder::success(400);
            }
                $position ->delete();

                return ResponseBuilder::success($position, 200 );

        }
        public function getpositionsbyid(Request $request, $id){

            $position= Position::Find($id);
        if (!$position ) {
            return ResponseBuilder::success(400);
        }
        $position -> get();
        return ResponseBuilder::success($position, 200 );

        }
}
