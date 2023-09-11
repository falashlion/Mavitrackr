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

    public function getById($id)
    {
        return Kpa::findOrFail($id);
    }

    public function create($data)
    {
        return Kpa::create($data);
    }
    public function update($id, $data)
    {
        $kpa = Kpa::findOrFail($id);
        $kpa->update($data);
        return $kpa;
    }

    public function delete($id)
    {
        $kpa = Kpa::findOrFail($id);
        $kpa->delete();
        return true;
    }
}
