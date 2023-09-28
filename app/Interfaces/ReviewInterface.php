<?php

namespace App\Interfaces;

interface ReviewInterface
{
    public function createReview($data);

    public function find($id);

    public function update($id, $data);

    public function delete($id);

    public function getAll($users);
}
