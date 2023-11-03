<?php

namespace App\Repositories;

use App\Interfaces\KpaRepositoryInterface;
use App\Models\Kpa;


class KpaRepository implements KpaRepositoryInterface
{
    /**
     * getAll
     *
     * @return object Returns the array of objects for all the kpas
     */
    public function getAll()
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
    public function getById($id)
    {
        $kpa = Kpa::findOrFail($id);

         return $kpa;
    }

    /**
     * create
     *
     * @param  array $data Contains the data to create a new kpa
     * @return object Returns the object of the created kpa
     */
    public function create($data)
    {
        return Kpa::create($data);
    }
    /**
     * update
     *
     * @param  string $id ID of the kpa
     * @param  array $data Contains the data to update the kpa
     * @return object Returns the object of the updated kpa
     */
    public function update($id,$data)
    {
        $kpa = Kpa::findOrFail($id);
        $kpa->update($data);

        return $kpa;
    }

    /**
     * delete
     *
     * @param  string $id ID of the kpa
     * @return boolean Returns a true for successsfully deleted kpa and false otherwise.
     */
    public function delete($id)
    {
        $kpa = Kpa::findOrFail($id);
        $kpa->delete();

        return true;
    }
}
