<?php

namespace App\Repositories;

interface KpaRepository
{
    public function getAllKpa($paginate);

    public function getKpaById($id);

    public function createKpa($data);

    public function updateKpa($id, $data);

    public function deleteKpa($id);
}
