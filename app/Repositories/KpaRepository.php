<?php

namespace App\Repositories;

use App\Interfaces\KpaRepositoryInterface;
use App\Models\Kpa;


class KpaRepository implements KpaRepositoryInterface
{
    /**
     * getAll
     *
     * @return object
     */
    public function getAll()
    {
        $kpas = Kpa::all();

        return $kpas;
    }

    /**
     * getById
     *
     * @param  string $id
     * @return object
     */
    public function getById($id)
    {
        $kpa = Kpa::findOrFail($id);

         return $kpa;
    }

    /**
     * create
     *
     * @param  array $data
     * @return object
     */
    public function create($data)
    {
        return Kpa::create($data);
    }
    /**
     * update
     *
     * @param  string $id
     * @param  array $data
     * @return object
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
     * @param  string $id
     * @return boolean
     */
    public function delete($id)
    {
        $kpa = Kpa::findOrFail($id);
        $kpa->delete();

        return true;
    }
}
