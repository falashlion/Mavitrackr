<?php

namespace App\Repositories;

use App\Interfaces\StrategicDomainRepositoryInterface;
use App\Models\StrategicDomain;

class StrategicDomainRepository implements StrategicDomainRepositoryInterface
{
    public function getAll()
    {
        return StrategicDomain::all();
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
