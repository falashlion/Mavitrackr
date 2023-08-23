<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StrategicDomain;
use App\Models\Feedback;
use App\Models\Kpa;
use App\Models\Kpi;
use App\Http\Requests\KpiRequest;
use App\Http\Requests\KpaRequest;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\StrategicDomainsRequest;
use App\Repositories\StrategicDomainRepository;
use App\Repositories\FeedbackRepository;





class objectivesController extends Controller
{
    //endpoints for StrategicDomain
    private $strategicDomainRepository;

    public function __construct(StrategicDomainRepository $strategicDomainRepository, )
    {
        $this->strategicDomainRepository = $strategicDomainRepository;

    }
    protected $feedbackRepository;

// public function __construct(FeedbackRepository $feedbackRepository)
// {
//     $this->feedbackRepository = $feedbackRepository;
// }

    public function getstrategic_domains()
    {
        $strategicDomains = $this->strategicDomainRepository->getAll();
        $data=[
            'strategic_domains' =>  $strategicDomains,
        ];
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
    public function getStrategicDomainById(Request $request, $id)
    {
        $strategicDomain = $this->strategicDomainRepository->getById($id);

        if (!$strategicDomain) {
            return response()->json([
                'status' => 'error',
                'message' => 'Strategic domain not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'strategic_domain' => $strategicDomain,
        ]);
    }

    public function createStrategicDomain(StrategicDomainsRequest $request)
    {
        $validatedData = $request->validated();

        $strategicDomain = $this->strategicDomainRepository->create($validatedData);

        return response()->json([
            'status' => 'success',
            'strategic_domain' => $strategicDomain,
            'message' => 'Strategic domain created successfully.',
        ]);
    }

    public function updateStrategicDomain(StrategicDomainsRequest $request, $id)
    {
        $validatedData = $request->validated();

        $strategicDomain = $this->strategicDomainRepository->update($id, $validatedData);

        return response()->json([
            'status' => 'success',
            'strategic_domain' => $strategicDomain,
            'message' => 'Strategic domain updated successfully.',
        ]);
    }

    public function deleteStrategicDomain(Request $request, $id)
    {
        $this->strategicDomainRepository->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Strategic domain deleted successfully.',
        ]);
    }
    // enpoints for feeedback
    public function getfeedback()
    {
        $feedback = $this->feedbackRepository->all();

        return response()->json([
            'status' => 'success',
            'users' => $feedback,
        ]);
    }
    public function getfeedbackbyKpiid(FeedbackRequest $request, $id)
    {
        $feedback = $this->feedbackRepository->getByKpiId($id);
        if (!$feedback) {
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
    public function createfeedback(FeedbackRequest $request, $id)
    {
        $Kpi = Kpi::Find($id);
        $feedback = $this->feedbackRepository->create([
            "comment"   =>  $request['comment'],
            "kpis_id" => $id,
        ]);
        return response ()-> json ( [
            "status"    =>"success",
            "data"      => $feedback,
            "Message"   =>"feedback created successfully."
        ]);
    }
    public function updatefeedback(FeedbackRequest $request, $id)
    {
        $feedback = $this->feedbackRepository->update([
            'comment'   =>  $request['comment'],
        ], $id);
        if (!$feedback) {
            return response()->json([
                'status'=> 'error',
                'message' =>'feedback could not found',
            ], 404);
        }

        return response() -> json ([
            "status"=>"updated",
            "message"=> "feedback updated",
        ]);
    }
    public function deletefeedback(Request $request, $id)
    {
        $result = $this->feedbackRepository->delete($id);
        if (!$result) {
            return response()->json([
                "status"=> "not found",
                "message"=> "feedback was not round"
            ], 404);
        }

        return response()->json([
            "status" => "success",
            "message" => "feedback successfully deleted ",
        ]);
    }

    //endpoints for kpas


    //endpoints for kpis

        // kpi scoring endpoints

public function getKpiscore(){
            $Kpi  = Kpi::paginate(10);
             return response()->json([
                 'status' => 'success',
                 'key performance indicator' => $Kpi,
             ]);
            }
public function updateKpiscore(KpiRequest $request, $id)
{
    $Kpi = Kpi::find($id);
    if (!$Kpi) {
        return response()->json([
            'status' => 'error',
            'message' => 'Key performance indicator score could not be found',
        ], JsonResponse::HTTP_NOT_FOUND);
    }

    // Perform the calculations to update the weighted average score
    $weights = Kpi::get($request['weight']);
    $scores = Kpi::get($request['score']);

    $total_weight = $weights->sum('percentage');
    $weighted_sum = $weights->zip($scores)->sum(function ($pair) {
        return $pair[0]['percentage'] * $pair[1]['score'];
    });

    $weighted_average = $total_weight > 0 ? $weighted_sum / $total_weight : null;

    // Update the KPI with the new values
    $Kpi->update([
        'weight' => $weights->toArray(),
        'score' => $scores->toArray(),
        'weighted_average_score' => $weighted_average,
    ]);

    return response()->json([
        'status' => 'updated',
        'message' => 'Key performance indicator scores are updated',
        'Kpiscore' => $Kpi,
    ], JsonResponse::HTTP_OK);
}

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
                ], JsonResponse::HTTP_OK);
        }


}
