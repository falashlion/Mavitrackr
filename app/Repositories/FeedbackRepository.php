<?php

namespace App\Repositories;

interface FeedbackRepository
{
    public function all();

    public function getByKpiId($id);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id);
}
