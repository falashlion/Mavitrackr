<?php

namespace App\Repositories;

use App\Interfaces\KpaRepositoryInterface;
use App\Models\Kpa;
use Illuminate\Database\Eloquent\Collection;

class KpaRepository implements KpaRepositoryInterface
{
    /**
     * getAll
     *
     * @return object Returns the array of objects for all the kpas
     */
    public function getAll():Collection
    {
        $kpas = Kpa::all();

        return $kpas;
    }

    /**
     * getById
     *
     * @param  string $id ID of the kpa
     * @return object Returns the object of the kpa with this ID
     */
    public function getById($id):Kpa
    {
        $kpa = Kpa::findOrFail($id);

         return $kpa;
    }

    /**
     * create
     *
     * @param  array $data Contains the data to create a new kpa
     * @return Kpa  Returns the object of the created kpa
     */
    public function create($data):Kpa
    {
        return Kpa::create($data);
    }
    /**
     * update
     *
     * @param  string $id ID of the kpa
     * @param  array $data Contains the data to update the kpa
     * @return Kpa Returns the object of the updated kpa
     */
    public function update(string $id,array $data):Kpa
    {
        $kpa = Kpa::findOrFail($id);
        $kpa->update($data);

        return $kpa;
    }

    /**
     * deletes a Key performance indicator from the database 
     * @param  string $id ID of the kpa
     * @return bool Returns a true for successsfully deleted kpa and false otherwise.
     */
    public function delete(string $id):bool
    {
        $kpa = Kpa::findOrFail($id);
        $kpa->delete();

        return true;
    }
}
