<?php

namespace App\Repositories;

use App\Interfaces\KpaRepositoryInterface;
use App\Models\Kpa;


class KpaRepository implements KpaRepositoryInterface
{
    public function getAll()
    {
         $kpas = Kpa::all();
        return $kpas;
    }

    public function getById($id, $e)
    {
        $kpa = Kpa::findOrFail($id);
         return $kpa;
    }

    public function create($data)
    {
        return Kpa::create($data);
    }
    public function update($id, $e, $data)
    {
        $kpa = Kpa::findOrFail($id);
        $kpa->update($data);
        return $kpa;
    }

    public function delete($id, $e)
    {
        $kpa = Kpa::findOrFail($id);
        $kpa->delete();
        return true;
    }
}
