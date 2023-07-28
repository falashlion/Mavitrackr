<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\strategic_domains;

class objectivesController extends Controller
{


    //endpoints for strategic domains
    public function getstrategic_domains(){
        $strategic_domains  = strategic_domains::all();
         return response()->json([
             'status' => 'success',
             'users' => $strategic_domains,
         ]);
        }

        public function createstrategic_domains(Request $request){
            $validatedData = $request-> validate([
            'title' => 'required|string'
            ]);

            //dd($validatedData);
            $strategic_domains = strategic_domains::create([
                "title"   =>  $validatedData['title'],
            ]);
        }
        public function updatestrategic_domains(Request $request, $id){

            $strategic_domains = strategic_domains::Find($id);
            if(!$strategic_domains) {
                return response()->json([
                    'status'=> 'error',
                    'message' =>'department could not found',
                ], 404);
            }

            $validatedData = $request-> validate([
                'title' => 'required|string'
                ]);
                dd($validatedData);
                $strategic_domains->update([
                    "title"=> $validatedData["title"],
                ]) ;
                return response() -> json ([
                    "status"=>"updated",
                    "message"=> "department updated",
                ]);

        }

        public function deletestrategic_domains(Request $request, $id){

            $strategic_domains = strategic_domains::Find($id);



            if (!$strategic_domains ) {
                return response()->json([
                    "status"=> "notfound",
                    "message"=> "department was not round"
                ], 404);
            }
                $strategic_domains ->delete();

                return response()->json([
                    "status" => "success",
                    "message" => "department successfully deleted ",
                ]);





        }

    // enpoints for feeedback

    //endpoints for kpas


    //endpoints for kpis
}
