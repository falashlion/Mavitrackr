<?php

namespace App\Repositories;

use App\Models\StrategicDomain;

class EloquentStrategicDomainRepository implements StrategicDomainRepository
{
    public function getAll()
    {
        return StrategicDomain::paginate(10);
    }

    public function getById($id)
    {
        return StrategicDomain::find($id);
    }

    public function create(array $data)
    {
        return StrategicDomain::create($data);
    }

    public function update($id, array $data)
    {
        $strategicDomain = StrategicDomain::find($id);
        if (!$strategicDomain) {
            return false;
        }

        return $strategicDomain->update($data);
    }

    public function delete($id)
    {
        $strategicDomain = StrategicDomain::find($id);
        if (!$strategicDomain) {
            return false;
        }

        return $strategicDomain->delete();
    }
}
