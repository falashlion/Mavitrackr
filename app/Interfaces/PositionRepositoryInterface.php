<?php

namespace App\Interfaces;



interface PositionRepositoryInterface
{
    public function getAllPositions();
    public function createPosition($data);
    public function updatePosition($id, $data);
    public function deletePosition($id);
    public function getPositionById($id);
}
