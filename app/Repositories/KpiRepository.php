<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Kpi;
use App\Models\User;
use App\Interfaces\KpiRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class KpiRepository implements KpiRepositoryInterface
{
    /**
     * getAll
     *
     * Retrieves all KPIs for a given user ID
     *
     * @param  string $id The ID of the user to retrieve KPIs for
     * @return Collection Returns an object containing all KPIs for the given user ID
     */
    public function getAll( string $id): Collection
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
     * @return Kpi Returns an object containing the KPI data
     */
    public function getById(string $id):Kpi
    {
            $kpi = Kpi::findOrFail($id);
            $kpi->user;
            $kpi->keyPerformanceArea;
            $kpi->keyPerformanceArea->strategicDomain;
            $kpi->feedback;

            return $kpi;
    }
    /**
     * Creates a new KPI
     * @param  array $data An array of data to create the KPI with
     * @return Kpi Returns an object containing the newly created KPI data
     */
    public function create( array $data): Kpi
    {
        return Kpi::create($data);
    }
    /**
     * Updates an existing KPI
     * @param  string $id The ID of the KPI to update
     * @param  array $data An array of data to update the KPI with
     * @return Kpi Returns an object containing the updated KPI data
     */
    public function update(string $id, array $data):Kpi
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
     * Deletes a KPI by ID
     * @param  string $id The ID of the KPI to delete
     * @return bool Returns true if the KPI was successfully deleted, false otherwise
     */
    public function delete(string $id): bool
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
     * @return Kpi  Returns an object containing the updated KPI data
     */
    public function createWeight(string $id, array $data):Kpi
    {
        $kpi = Kpi::findOrFail($id);
        $kpi -> update($data);

        return $kpi;
    }
    /**
     * Updates the score of a KPI
     * @param  string $id The ID of the KPI to update the score for
     * @param  array $data An array of data to update the KPI score with
     * @return Kpi Returns an object containing the updated KPI data
     */
    public function createScore(string $id, array $data):Kpi
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
     * @return Kpi Returns an object containing the average score of all KPIs for the authenticated user
     */
    public function getAverageScore():Kpi
    {
        $user_id = auth()->user()->id;
        $averages=Kpi::where('user_id', $user_id)->select('weighted_average_score')->first();

        return $averages;
    }
    /**
     * Retrieves the average score of all KPIs for a given user ID
     * @param  string $id The ID of the user to retrieve the average score for
     * @return Kpi Returns an object containing the average score of all KPIs for the given user ID
     */
    public function getAverageScoreByUserId(string $id):Kpi
    {
        $averages=Kpi::where('user_id', $id)->select('weighted_average_score')->first();

        return $averages;
    }
    /**
     * Retrieves all KPIs for a given user ID
     * @param  string $id The ID of the user to retrieve KPIs for
     * @return Collection Returns an object containing all KPIs for the given user ID
     */
    public function getByUserId(string $id): Collection
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
     * Retrieves all KPIs for direct reports of the authenticated user
     * @return Collection Returns an object containing all KPIs for direct reports of the authenticated user
     */
    public function getDirectReportKpis(): Collection
    {
        $directReports = auth()->user()->employees->pluck('id')->toArray();
        $kpis = Kpi::with('user')->whereIn('user_id', $directReports)->orderBy('created_at','DESC')->get();

        return $kpis;
    }
}
