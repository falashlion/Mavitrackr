<?php

namespace App\Repositories;

use App\Models\Kpa;

class EloquentKpaRepository implements KpaRepository{
    public function getAllKpa($paginate)
    {
        if($paginate == 'all'){
        $kpa = Kpa::all();
        }
        else{
            $kpa = Kpa::paginate($paginate);
        }
        return $kpa;
    }

    // public function getAllKpa()
    // {
    //     return Kpa::all();
    // }

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
