<?php

namespace App\Repositories;

use App\Interfaces\StrategicDomainRepositoryInterface;
use App\Models\StrategicDomain;

class StrategicDomainRepository implements StrategicDomainRepositoryInterface
{
    /**
     * getAll
     *
     * @return object
     */
    public function getAll()
    {
        return StrategicDomain::all();
    }
    /**
     * getById
     *
     * @param  string $id
     * @return object
     */
    public function getById($id)
    {
        $strategicDomain = StrategicDomain::findOrFail($id);
        return $strategicDomain;
    }

    /**
     * create
     *
     * @param  array $data
     * @return object
     */
    public function create(array $data)
    {
        return StrategicDomain::create($data);
    }
    /**
     * update
     *
     * @param  string $id
     * @param  array $data
     * @return object
     */
    public function update($id, array $data)
    {
        $strategicDomain = StrategicDomain::findOrFail($id);
        $strategicDomain->update($data);
        return $strategicDomain;
    }
    /**
     * delete
     *
     * @param  string $id
     * @return  object
     */
    public function delete($id)
    {
        $strategicDomain = StrategicDomain::findOrFail($id);
        $strategicDomain->delete();
        return $strategicDomain;
    }
}
