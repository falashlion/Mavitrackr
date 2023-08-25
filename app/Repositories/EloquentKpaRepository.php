<?php

namespace App\Repositories;

use App\Models\Kpa;
use GuzzleHttp\Psr7\Request;

class EloquentKpaRepository implements KpaRepository{

    public function getAllKpa($data)
    {
        $page = $data->query('paginate') ?? '10';
         $kpas = Kpa::paginate($page);
        return $kpas;
    }

    public function getKpaById($id)
    {
        return Kpa::findOrFail($id);
    }

    public function createKpa($data)
    {
        return Kpa::create($data);
    }

    public function updateKpa($id, $data)
    {
        $kpa = Kpa::findOrFail($id);
        $kpa->update($data);
        return $kpa;
    }

    public function deleteKpa($id)
    {
        $kpa = Kpa::findOrFail($id);
        $kpa->delete();
        return true;
    }
}
