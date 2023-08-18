<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StrategicDomain;
use App\Models\Feedback;
use App\Models\Kpa;
use App\Models\Kpi;

class objectivesController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('jwt.verify');
    // }

    //endpoints for StrategicDomain
    public function getstrategic_domains(){
        $strategic_domains  = StrategicDomain::paginate(10);
         return response()->json([
             'status' => 'success',
             'users' => $strategic_domains,
         ]);
        }


        public function getdepartmentsbyid(Request $request, $id){
            $strategic_domains= StrategicDomain::Find($id);
            if (!$strategic_domains ) {
                return response()->json([
                    'status'=> 'error',
                    'message' =>'strategic domian could not found',
                ], 404);
            }
            $strategic_domains -> get();
            return response()->json([
                "status" => "success",
                "data"=> $strategic_domains,
            ]);
        }

        public function createstrategic_domains(Request $request){
            $validatedData = $request-> validate([
            'title' => 'required|string'
            ]);

            //dd($validatedData);
            $strategic_domains = StrategicDomain::insert([
                "title"   =>  $validatedData['title'],
            ]);
            return response ()-> json ( [
                "status"    =>"success",
                "data"      => $strategic_domains,
                "Message"   =>"strategicdomain created successfully."]);
        }
        public function updatestrategic_domains(Request $request, $id){

            $strategic_domains = StrategicDomain::Find($id);
            if(!$strategic_domains) {
                return response()->json([
                    'status'=> 'error',
                    'message' =>'strategic domain could not found',
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
                    "message"=> "strategic domain  updated",
                    "strategic_domains" => $strategic_domains,
                ]);

        }

        public function deletestrategic_domains(Request $request, $id){

            $strategic_domains = StrategicDomain::Find($id);



            if (!$strategic_domains ) {
                return response()->json([
                    "status"=> "notfound",
                    "message"=> "startegic domain was not round"
                ], 404);
            }
                $strategic_domains ->delete();

                return response()->json([
                    "status" => "success",
                    "message" => "strategic domain successfully deleted ",
                ]);

        }

    // enpoints for feeedback
    public function getfeedback(){
        $feedback  = Feedback::paginate(10);
         return response()->json([
             'status' => 'success',
             'users' => $feedback,
         ]);
        }

        public function getfeedbackbyKpiid(Request $request, $id){
            $feedback = Feedback::Where('kpis_id', $id)->get();
            if ($feedback->isEmpty()) {
                return response()->json([
                    'status'=> 'error',
                    'message' =>'feedback for this key performance indicator could not be found',
                ], 404);
            }

            return response()->json([
                "status" => "success",
                "data"=> $feedback,
            ]);
        }
        public function createfeedback(Request $request, $id){
            $Kpi = Kpi::Find($id);

            $validatedData = $request-> validate([
            'comment' => 'required|string'
            ]);
            $feedback = Feedback::insert([
                "comment"   =>  $validatedData['comment'],
            ]);
            return response ()-> json ( [
                "status"    =>"success",
                "data"      => $feedback,
                "Message"   =>"feedback created successfully."]);
        }
        public function updatefeedback(Request $request, $id){

            $feedback = Feedback::Find($id);
            if(!$feedback) {
                return response()->json([
                    'status'=> 'error',
                    'message' =>'feedback could not found',
                ], 404);
            }

            $validatedData = $request-> validate([
                'comment' => 'required|string'
                ]);
                dd($validatedData);
                $$feedback->update([
                    "comment"   =>  $validatedData['comment'],
                ]) ;
                return response() -> json ([
                    "status"=>"updated",
                    "message"=> "feedback updated",
                ]);

        }

        public function deletefeedback(Request $request, $id){

            $feedback = Feedback::Find($id);
            if (!$feedback ) {
                return response()->json([
                    "status"=> "notfound",
                    "message"=> "feedback was not round"
                ], 404);
            }
            $feedback ->delete();

                return response()->json([
                    "status" => "success",
                    "message" => "feedback successfully deleted ",
                ]);
        }

    //endpoints for kpas
    public function getKpa(){
        $Kpa = Kpa::paginate(10);
        //$Kpa = Kpa::select('title')->get();

         return response()->json([
             'status' => 'success',
             'key performance areas' => $Kpa,
         ]);
        }

        public function getKpabyid(Request $request, $id){
            $Kpa= Kpa::Find($id);
            if (!$Kpa ) {
                return response()->json([
                    'status'=> 'error',
                    'message' =>'key performance area could not found',
                ], 404);
            }
            $Kpa -> get();
            return response()->json([
                "status" => "success",
                "data"=> $Kpa,
            ]);
        }

        public function createKpa(Request $request){
            $validatedData = $request-> validate([
            'title' => 'required|string'
            ]);

            //dd($validatedData);
            $Kpa = Kpa::insert([
                "title"   =>  $validatedData['title'],
            ]);
            return response ()-> json ( [
                "status"    =>"success",
                "data"      => $Kpa,
                "Message"   =>"key performance area created successfully."], 200);
        }
        public function updateKpa(Request $request, $id){

            $Kpa = Kpa::Find($id);
            if(!$Kpa) {
                return response()->json([
                    'status'=> 'error',
                    'message' =>'key performance area could not found',
                ], 404);
            }

            $validatedData = $request-> validate([
                'title' => 'required|string'
                ]);
                //dd($validatedData);
                $Kpa->update([
                    "title"=> $validatedData["title"],
                ]) ;
                return response() -> json ([
                    "status"=>"updated",
                    "message"=> "key performance areas are updated",
                    "Kpa" => $Kpa,
                ]);

        }

        public function deleteKpa(Request $request, $id){

            $Kpa = Kpa::Find($id);

            if (!$Kpa) {
                return response()->json([
                    "status"=> "notfound",
                    "message"=> "key performance area was not round"
                ], 404);
            }
            $Kpa->delete();

                return response()->json([
                    "status" => "success",
                    "message" => "key performance area successfully deleted ",
                ]);
        }

    //endpoints for kpis
    public function getKpi(){
        // $Kpi  = Kpi::all();
        $Kpi = Kpi::select('title')->paginate(10);
         return response()->json([
             'status' => 'success',
             'users' => $Kpi,
         ]);
        }


        public function getKpibyid(Request $request, $id){
            $Kpi= Kpi::Find($id);
            if (!$Kpi) {
                return response()->json([
                    'status'=> 'error',
                    'message' =>'key performance indicators could not found',
                ], 404);
            }
            $Kpi -> get();
            return response()->json([
                "status" => "success",
                "data"=> $Kpi,
            ]);
        }

        public function createKpi(Request $request){
            $validatedData = $request-> validate([
            'title' => 'required|string',
            'kpas_id' => 'integer',
            'users_id' => 'integer',
            ]);


            $Kpi = Kpi::insert([
                "title"   =>  $validatedData['title'],
                "kpas_id"     =>  $validatedData ['kpas_id'],
                "users_id"     =>  $validatedData ['users_id'],
            ]);
            return response ()-> json ( [
                "status"    =>"success",
                "data"      => $Kpi,
                "Message"   =>"key performance area created successfully."], 200);
        }
        public function updateKpi(Request $request, $id){

            $Kpi = Kpi::Find($id);
            if(!$Kpi) {
                return response()->json([
                    'status'=> 'error',
                    'message' =>'key performance indicator could not found',
                ], 404);
            }

            $validatedData = $request-> validate([
            'title' => 'required|string',
            'kpas_id' => 'integer',
            'user_id' => 'integer'
                ]);

                $Kpi->update([
                "title"   =>  $validatedData['title'],
                "kpas_id"     =>  $validatedData ['kpas_id'],
                "user_id"     =>  $validatedData ['user_id']
                ]) ;
                return response() -> json ([
                    "status"=>"updated",
                    "message"=> "key performance indicator are updated",
                    "Kpi" => $Kpi,
                ]);

        }

        public function deleteKpi(Request $request, $id){

            $Kpi = Kpi::Find($id);

            if (!$Kpi) {
                return response()->json([
                    "status"=> "notfound",
                    "message"=> "key performance indicator was not round"
                ], 404);
            }
            $Kpi->delete();

                return response()->json([
                    "status" => "success",
                    "message" => "key performance indicators successfully deleted ",
                ]);
        }
        // kpi scoring endpoints

        public function getKpiscore(){
            $Kpi  = Kpi::paginate(10);
             return response()->json([
                 'status' => 'success',
                 'key performance indicator' => $Kpi,
             ]);
            }
public function updateKpiscore(Request $request, $id)
{
    $Kpi = Kpi::find($id);
    if (!$Kpi) {
        return response()->json([
            'status' => 'error',
            'message' => 'Key performance indicator score could not be found',
        ], 404);
    }

    $validatedData = $request->validate([
        // 'indicators' => 'required|array',
        // 'indicators.*' => 'required|string',
        'weight' => 'required|numeric',
        // 'weights.*.percentage' => 'required|numeric',
        'score' => 'required|numeric',
        // 'scores.*.score' => 'required|numeric',
    ]);

    // Perform the calculations to update the weighted average score
    $weights = Kpi::get($validatedData['weight']);
    $scores = Kpi::get($validatedData['score']);

    $total_weight = $weights->sum('percentage');
    $weighted_sum = $weights->zip($scores)->sum(function ($pair) {
        return $pair[0]['percentage'] * $pair[1]['score'];
    });

    $weighted_average = $total_weight > 0 ? $weighted_sum / $total_weight : null;

    // Update the KPI with the new values
    $Kpi->update([
        // 'indicators' => $validatedData['indicators'],
        'weight' => $weights->toArray(),
        'score' => $scores->toArray(),
        'weighted_average_score' => $weighted_average,
    ]);

    return response()->json([
        'status' => 'updated',
        'message' => 'Key performance indicator scores are updated',
        'Kpiscore' => $Kpi,
    ]);
}


        // public function updateKpiscore(Request $request, $id){

        //     $Kpi = Kpi::Find($id);
        //     if(!$Kpi) {
        //         return response()->json([
        //             'status'=> 'error',
        //             'message' =>'key performance indicator  score could not be found',
        //         ], 404);
        //     }

        //     $validatedData = $request-> validate([
        //         'indicators' => 'required|integer',
        //         'weight' => 'required|integer',
        //         'score' => 'required|integer',
        //         'weighted_average_score' => 'integer'
        //         ]);
        //         //dd($validatedData);
        //         $Kpi->update([
        //         "indicators"   =>  $validatedData['indicators'],
        //         "weight"     =>  $validatedData ['weight'],
        //         "score"     =>  $validatedData ['score'],
        //         "weighted_average_score"     =>  $validatedData ['weighted_average_score'],
        //         ]) ;
        //         return response() -> json ([
        //             "status"=>"updated",
        //             "message"=> "key performance indicator scores are updated",
        //             "Kpiscore" => $Kpi,
        //         ]);

        // }

        public function deleteKpiscore(Request $request, $id){

            $Kpi = Kpi::Find($id);

            if (!$Kpi) {
                return response()->json([
                    "status"=> "not found",
                    "message"=> "key performance indicator's score was not found"
                ], 404);
            }
            $Kpi->delete();

                return response()->json([
                    "status" => "success",
                    "message" => "key performance indicator's score was successfully deleted ",
                ]);
        }


}
