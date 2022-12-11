<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface UsersRepository extends BaseRepository
{
    public function getUsersWithState(string $state): Model|Builder;
}
