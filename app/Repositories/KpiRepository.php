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
     * @param  string $id
     * @return object
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
     * @param  string $id
     * @return object
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
     * @param  array $data
     * @return object
     */
    public function create( array $data): object
    {
        return Kpi::create($data);
    }
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
     * @param  string $id
     * @return boolean
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
     * @param  string $id
     * @param  array $data
     * @return object
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
     * @param  string $id
     * @param  array $data
     * @return object
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
     * @return object
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
     * @param  string $id
     * @return object
     */
    public function getAverageScoreByUserId(string $id){
        $averages=Kpi::where('user_id', $id)->select('weighted_average_score')->first();

        return $averages;
    }
    /**
     * getByUserId
     *
     * @param  string $id
     * @return object
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
     * @return object
     */
    public function getDirectReportKpis(): object
    {
        $directReports = auth()->user()->employees->pluck('id')->toArray();
        $kpis = Kpi::with('user')->whereIn('user_id', $directReports)->orderBy('created_at','DESC')->get();

        return $kpis;
    }
}
