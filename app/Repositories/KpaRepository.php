<?php

namespace App\Repositories;

interface KpaRepositoryInterface
{
    public function getAllKpa();

    public function getKpaById($id);

    public function createKpa($data);

    public function updateKpa($id, $data);

    public function deleteKpa($id);
}
