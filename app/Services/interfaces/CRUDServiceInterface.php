<?php

namespace App\Services\Interfaces;

interface CRUDServiceInterface
{
    public function create(array $inputs);
    public function read(int $id);
    public function update(int $id, array $inputs);
    public function delete(int $id);
}
