<?php

namespace App\Repositories;

use App\Models\Kpi;
use App\Models\User;
use App\Interfaces\KpiRepositoryInterface;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class KpiRepository implements KpiRepositoryInterface
{
    public function getAll($id)
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
    public function getById($id, $e)
    {
            $kpi = Kpi::findOrFail($id);
            $kpi->keyPerformanceArea;
            $kpi->keyPerformanceArea->strategicDomain;
            $kpi->feedback;
            return $kpi;
    }
    public function create($data)
    {
        return Kpi::create($data);
    }
    public function update($id, $data, $e)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->update($data);
        return $kpi;
    }

    public function delete($id, $e)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->delete();
        return true;
    }
    public function createWeight($id, $data, $e)
    {
            $kpi = Kpi::findOrFail($id);
            $kpi -> update($data);
            return $kpi;
    }

    public function createScore($id, $data, $e)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi -> update($data);
        // Calculate weighted average score per user_id
        $kpis = Kpi::select('user_id')->distinct()->get();
        foreach ($kpis as $kpi_user)
        {
            $user_id = $kpi_user->user_id;
            $kpi_scores = Kpi::where('user_id', $user_id)->get();
            $total_weight = 0;
            $weighted_sum = 0;
            foreach ($kpi_scores as $score) {
                $total_weight += $score->weight;
                $weighted_sum += $score->score * $score->weight;
            }
            if ($total_weight > 0) {
                $weighted_average = $weighted_sum / $total_weight;
            } else {
                $weighted_average = null;
            }
            Kpi::where('user_id', $user_id)->update(['weighted_average_score' => $weighted_average]);
        }
        return $kpi;
    }
    public function getByUserId($id, $e)
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

    // $kpi = Kpi::findOrFail($id);
    // $kpi->update($data);
    // Calculate weighted average score per user_id
    // $kpis = Kpi::select('user_id')->distinct()->get();
    // foreach ($kpis as $kpi) {
    //     $user_id = $kpi->user_id;
    //     $kpi_scores = Kpi::where('user_id', $user_id)->get();
    //     $total_weight = 0;
    //     $weighted_sum = 0;
    //     foreach ($kpi_scores as $score) {
    //         $total_weight += $score->weight;
    //         $weighted_sum += $score->score * $score->weight;
    //     }
    //     $weighted_average = $weighted_sum / $total_weight;
    //     Kpi::where('user_id', $user_id)->update(['weighted_average_score' => $weighted_average]);
    // }

}
