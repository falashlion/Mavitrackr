<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Kpi;
use App\Models\User;
use App\Interfaces\KpiRepositoryInterface;
use Doctrine\DBAL\Types\BooleanType;
use Illuminate\Http\Response;

class KpiRepository implements KpiRepositoryInterface
{
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

    public function getById(string $id)
    {
            $kpi = Kpi::findOrFail($id);
            $kpi->user;
            $kpi->keyPerformanceArea;
            $kpi->keyPerformanceArea->strategicDomain;
            $kpi->feedback;

            return $kpi;
    }
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
            $weight = ['weight'];
            $data = collect($data)->except($weight)->toArray();
        }else {
            $data;
        }

        $kpi->update($data);

        return $kpi;
    }

    public function delete(string $id)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->delete();

        return true;
    }
    public function createWeight(string $id, array $data)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi -> update($data);

        return $kpi;
    }
    public function createScore(string $id, array $data)
    {
        $kpi = Kpi::findOrFail($id);
        $kpiUserId = $kpi->user_id;
        $userId = auth()->user()->id;
        if ($kpiUserId == $userId){
            $score = ['score'];
            $data = collect($data)->except($score)->toArray();
        }
        $kpi -> update($data);

        return $kpi;
    }
    public function getAverageScore():object
    {
        $user_id = auth()->user()->id;
        $averages=Kpi::where('user_id', $user_id)->select('weighted_average_score')->first();

        return $averages;

    }
    public function getAverageScoreByUserId(string $id){
        $averages=Kpi::where('user_id', $id)->select('weighted_average_score')->first();

        return $averages;
    }
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

    public function getDirectReportKpis(): object
    {
        $directReports = auth()->user()->employees->pluck('id')->toArray();
        $kpis = Kpi::with('user')->whereIn('user_id', $directReports)->orderBy('created_at','DESC')->get();

        return $kpis;
    }
}
