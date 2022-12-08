<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface CRUDServiceInterface
{
    public function create(array $inputs):Model;
    public function read(int $id):Model;
    public function update(int $id, array $inputs):bool;
    public function delete(int $id):bool;
}
