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
        $strategicDomain = StrategicDomain::findOrFail($id);
        return $strategicDomain;
    }

    public function create(array $data)
    {
        return StrategicDomain::create($data);
    }
    public function update($id, array $data)
    {
        $strategicDomain = StrategicDomain::findOrFail($id);
        $strategicDomain->update($data);
        return $strategicDomain;
    }
    public function delete($id)
    {
        $strategicDomain = StrategicDomain::findOrFail($id);
        $strategicDomain->delete();
        return $strategicDomain;
    }
}
