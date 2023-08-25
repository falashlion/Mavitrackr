<?php

namespace App\Repositories;

interface KpaRepository
{
    public function getAllKpa($data);

    public function getKpaById($id);

    public function createKpa($data);

    public function updateKpa($id, $data);

    public function deleteKpa($id);
}
