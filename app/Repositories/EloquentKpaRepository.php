<?php

namespace App\Repositories;

use App\Models\Kpa;
use GuzzleHttp\Psr7\Request;

class EloquentKpaRepository implements KpaRepository{

    public function getAll($data)
    {
        $page = $data->query('paginate') ?? '10';
         $kpas = Kpa::paginate($page);
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
