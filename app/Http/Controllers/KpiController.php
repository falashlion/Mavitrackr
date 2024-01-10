<?php

namespace App\Http\Controllers;

use App\Http\Requests\kpiScoreRequest;
use App\Http\Requests\kpiUpdateRequest;
use App\Models\Kpi;
// use Illuminate\Http\JsonResponse;
use App\interfaces\KpiRepositoryInterface;
use App\Http\Requests\KpiRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\kpiStoreRequest;
use Illuminate\Http\Response as Responses;
use APP\Exceptions\NonWeightException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as Response;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;


class KpiController extends Controller
{
    private $KpiRepository;
    public function __construct(KpiRepositoryInterface $KpiRepository)
    {
        $this->KpiRepository = $KpiRepository;
        $this->middleware('jwt.auth');
        // $this->middleware('permission:kpis edit')->only('updateKpi');
        // $this->middleware('permission:kpisweight edit')->only('createKpiWeight');
        // $this->middleware('permission:kpisScore edit')->only('createKpiScore');
        // $this->middleware('permission:kpis list')->only('getKpiByUserId',);
        // $this->middleware('permission:kpis delete')->only(['deleteKpiDetails']);
    }

    /**
     * getAllKpis
     * @return Response response builder object with an array of the kpis for the authenticated user
     */
    public function getAllKpis():Response
    {
        Auth::user();
        $id = auth()->id();
        $kpis = $this->KpiRepository->getAll($id);

        return ResponseBuilder::success($kpis, 200);
    }
    /**
     * getKpiById
     *
     * @param  string $id user id of the whose kpis are to be gotten
     * @return Response response builder object with an array of the kpis for the user with the user id
     */
    public function getKpiById(string $id):Response
    {
        $kpi = $this->KpiRepository->getById($id);

        return ResponseBuilder::success($kpi, 200);
    }
    /**
     * createKpi
     *
     * @param  KpiRequest $request object of the properties required to create a kpi
     * @return Response The response builder object with an object of the created kpi
     */
    public function createKpi(KpiRequest $request):Response
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $kpi = $this->KpiRepository->create($data);
        $this->weightedAverageScore();

        return ResponseBuilder::success($kpi,201,null,201);
    }
    /**
     * updateKpi
     *
     * @param  kpiUpdateRequest $request object of the properties required to update a kpi
     * @param  string $id The uuid of the kpi to be updated
     * @return Response The response builder object with an object of the updated kpi
     */

    public function updateKpi(kpiUpdateRequest $request, string $id):Response
    {
        $kpi = $this->KpiRepository->update($id,$request->all());

        return ResponseBuilder::success($kpi,200);
    }
    /**
     * deleteKpiDetails
     *
     * @param  string $id uuid of the kpi to be deleted
     * @return Response no conntent http response returned by the reponse builder
     */
    public function deleteKpiDetails($id):Response
    {
        $kpi = Kpi::findOrFail($id);
        $kpiUserId = $kpi->user_id;
        $userId = auth()->user()->id;
        if ($kpiUserId == $userId){
            if (!$kpi->weight == null){
                return response()->json([
                    'success' => false,
                    'code'=> 403,
                    'locale'=> 'en',
                    'message'=> 'You are not authorized to delete this KPI.',
                    'data'=>''
                ], Response::HTTP_FORBIDDEN);
            }
        }
        $this->KpiRepository->delete($id);
        $this->weightedAverageScore();

        return ResponseBuilder::success(204,null,null,204);
    }
    /**
     * createKpiWeight
     *
     * @param  kpiStoreRequest $request object carrying the value of the weight to be created
     * @param  string $id uuid of the kpi to be given a weight value
     * @return Response Response builder object with the updated kpi with its weight
     */
    public function createKpiWeight(kpiStoreRequest $request, string $id):Response
    {
        $kpi = $this->KpiRepository->createWeight($id, $request->all());
        $this->weightedAverageScore();

        return ResponseBuilder::success($kpi,201,null,201);
    }
    /**
     * createKpiScore
     *
     * @param  kpiScoreRequest $request object carrying the value of the score to be created
     * @param  string $id uuid of the kpi to be given a score value
     * @return Response Response builder object with the updated kpi with its score
     */
    public function createKpiScore(kpiScoreRequest $request, string $id):?Response
    {
        $kpi = Kpi::findOrFail($id);
        if ($kpi->weight = null) {
            // throw new NonWeightException("KPI does not have a weight");
            return response()->json([
                'success' => false,
                'code'=> 403,
                'locale'=> 'en',
                'message'=> 'KPI does not have a weight Can not assign score',
                'data'=>''
        ], Responses::HTTP_FORBIDDEN);
        }
        $kpi = $this->KpiRepository->createScore($id, $request->all());
        $this->weightedAverageScore();

        return ResponseBuilder::success($kpi,201,null,201);
    }

    /**
     * getKpiByUserId
     *
     * @param  string $id user id of the user whose kpis are to be retrieved
     * @return Response Response builder object with the  kpis for this user
     */
    public function getKpiByUserId(string $id):Response
    {
        $kpi = $this->KpiRepository->getByUserId($id);

        return ResponseBuilder::success($kpi,200);
    }

    /**
     * averageScore
     *
     * @return Response Response builder object with the weighted average score for the authenticated user
     */
    public function averageScore():Response
    {
        $average = $this->KpiRepository->getAverageScore();
        $this->weightedAverageScore();

        return ResponseBuilder::success($average,200,null,200);
    }

    /**
     * averageScoreByUserId
     *
     * @param  string $id the user id of the the user whose weighted average score is to be retrieved
     * @return Response Response builder object with the weighted average score for the users whose id is passed in the parameters
     */
    public function averageScoreByUserId(string $id):Response
    {
        $average = $this->KpiRepository->getAverageScoreByUserId($id);
        $this->weightedAverageScore();

        return ResponseBuilder::success($average,200,null,200);
    }

    /**
     * getKpisForAllDirectReports
     *
     *  Retrieves all KPIs for direct reports of the authenticated user
     * @return Response Returns an object containing all KPIs for direct reports of the authenticated user
     */
    public function getKpisForAllDirectReports():Response
    {
        $kpis = $this->KpiRepository->getDirectReportKpis();
        $this->weightedAverageScore();

        return ResponseBuilder::success($kpis,200,null,200);
    }
    /**
     * weightedAverageScore
     *
     * Calculates the weighted average score per user ID
     * @return void
     */
    public function weightedAverageScore():void
    {

        $kpis = Kpi::select('user_id')->distinct()->get();
        foreach ($kpis as $kpi_user)
        {
            $user_id = $kpi_user->user_id;
            $kpi_scores = Kpi::where('user_id', $user_id)->get();
            $weighted_sum = 0;
            $num_scores = count($kpi_scores);
            foreach ($kpi_scores as $score) {
                $weighted_sum += ($score->score * $score->weight) / 100; // multiply score by weight and divide by 100
            }
            if ($num_scores > 0) {
                $weighted_average = $weighted_sum ;
            } else {
                $weighted_average = null;
            }
            Kpi::where('user_id', $user_id)->update(['weighted_average_score' => $weighted_average]);
        }
    }
}
