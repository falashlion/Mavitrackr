<?php

namespace App\Repositories;

use App\Interfaces\StrategicDomainRepositoryInterface;
use App\Models\StrategicDomain;
use Illuminate\Database\Eloquent\Collection;

class StrategicDomainRepository implements StrategicDomainRepositoryInterface
{
    /**
     * gets All strategic domains in the database
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return StrategicDomain::all();
    }
    /**
     * get strategic domain by id
     *
     * @param  string $id
     * @return StrategicDomain
     */
    public function getById(string $id): StrategicDomain
    {
        $strategicDomain = StrategicDomain::findOrFail($id);

        return $strategicDomain;
    }

    /**
     * creates a new strategic domain
     *
     * @param  array $data
     * @return StrategicDomain
     */
    public function create(array $data): StrategicDomain
    {
        return StrategicDomain::create($data);
    }
    /**
     * updates a strategic domain
     *
     * @param  string $id
     * @param  array $data
     * @return StrategicDomain
     */
    public function update(string $id, array $data): StrategicDomain
    {
        $strategicDomain = StrategicDomain::findOrFail($id);
        $strategicDomain->update($data);

        return $strategicDomain;
    }
    /**
     * deletes a startegic domain using it's id
     * @param  string $id
     * @return  bool
     */
    public function delete($id): bool
    {
        $strategicDomain = StrategicDomain::findOrFail($id);
        $strategicDomain->delete();

        return true;
    }
}
