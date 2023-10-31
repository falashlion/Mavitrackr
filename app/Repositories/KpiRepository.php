<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Kpi;
use App\Models\User;
use App\Interfaces\KpiRepositoryInterface;


class KpiRepository implements KpiRepositoryInterface
{
    /**
     * getAll
     *
     * Retrieves all KPIs for a given user ID
     *
     * @param  string $id The ID of the user to retrieve KPIs for
     * @return object Returns an object containing all KPIs for the given user ID
     */
    public function getAll( string $id): object
    {
        $kpis = Kpi::where('user_id', $id)->get();
        foreach ($kpis as $user)
        {
            $user->keyPerformanceArea->title;
            $user->keyPerformanceArea->strategicDomain;
            $user->feedback;
        }

        return $kpis;
    }

    /**
     * getById
     *
     * Retrieves a KPI by ID
     *
     * @param  string $id The ID of the KPI to retrieve
     * @return object Returns an object containing the KPI data
     */
    public function getById(string $id)
    {
            $kpi = Kpi::findOrFail($id);
            $kpi->user;
            $kpi->keyPerformanceArea;
            $kpi->keyPerformanceArea->strategicDomain;
            $kpi->feedback;

            return $kpi;
    }
    /**
     * create
     *
     * Creates a new KPI
     *
     * @param  array $data An array of data to create the KPI with
     * @return object Returns an object containing the newly created KPI data
     */
    public function create( array $data): object
    {
        return Kpi::create($data);
    }
        /**
     * update
     *
     * Updates an existing KPI
     *
     * @param  string $id The ID of the KPI to update
     * @param  array $data An array of data to update the KPI with
     * @return object Returns an object containing the updated KPI data
     */
    public function update(string $id, array $data)
    {
        $kpi = Kpi::findOrFail($id);
        $kpiUserId = $kpi->user_id;
        $userId = auth()->user()->id;
        if ($kpiUserId == $userId){
            $data = collect($data)->except(['weight'])->toArray();
        }
        $kpi->update($data);

        return $kpi;
    }

    /**
     * delete
     *
     * Deletes a KPI by ID
     *
     * @param  string $id The ID of the KPI to delete
     * @return boolean Returns true if the KPI was successfully deleted, false otherwise
     */
    public function delete(string $id)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->delete();

        return true;
    }
    /**
     * createWeight
     *
     * Updates the weight of a KPI
     *
     * @param  string $id The ID of the KPI to update the weight for
     * @param  array $data An array of data to update the KPI weight with
     * @return object Returns an object containing the updated KPI data
     */
    public function createWeight(string $id, array $data)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi -> update($data);

        return $kpi;
    }
    /**
     * createScore
     *
     * Updates the score of a KPI
     *
     * @param  string $id The ID of the KPI to update the score for
     * @param  array $data An array of data to update the KPI score with
     * @return object Returns an object containing the updated KPI data
     */
    public function createScore(string $id, array $data)
    {
        $kpi = Kpi::findOrFail($id);
        $kpiUserId = $kpi->user_id;
        $userId = auth()->user()->id;
        if ($kpiUserId == $userId){
            $data = collect($data)->except(['score'])->toArray();
        }
        $kpi -> update($data);

        return $kpi;
    }
    /**
     * getAverageScore
     *
     * Retrieves the average score of all KPIs for the authenticated user
     *
     * @return object Returns an object containing the average score of all KPIs for the authenticated user
     */
    public function getAverageScore():object
    {
        $user_id = auth()->user()->id;
        $averages=Kpi::where('user_id', $user_id)->select('weighted_average_score')->first();

        return $averages;

    }
    /**
     * getAverageScoreByUserId
     *
     * Retrieves the average score of all KPIs for a given user ID
     *
     * @param  string $id The ID of the user to retrieve the average score for
     * @return object Returns an object containing the average score of all KPIs for the given user ID
     */
    public function getAverageScoreByUserId(string $id){
        $averages=Kpi::where('user_id', $id)->select('weighted_average_score')->first();

        return $averages;
    }
    /**
     * getByUserId
     *
     * Retrieves all KPIs for a given user ID
     *
     * @param  string $id The ID of the user to retrieve KPIs for
     * @return object Returns an object containing all KPIs for the given user ID
     */
    public function getByUserId(string $id)
    {
        $user = User::findOrFail($id);
        $kpis = Kpi::where('user_id',$id)->get();
        foreach($kpis as $kpi){
        $kpi->keyPerformanceArea;
        $kpi->keyPerformanceArea->strategicDomain;
        $kpi->feedback;
        }

        return $kpis;
    }
    /**
     * getDirectReportKpis
     *
     * Retrieves all KPIs for direct reports of the authenticated user
     *
     * @return object Returns an object containing all KPIs for direct reports of the authenticated user
     */
    public function getDirectReportKpis(): object
    {
        $directReports = auth()->user()->employees->pluck('id')->toArray();
        $kpis = Kpi::with('user')->whereIn('user_id', $directReports)->orderBy('created_at','DESC')->get();

        return $kpis;
    }
}
