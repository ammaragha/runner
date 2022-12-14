<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface UsersRepository extends BaseRepository
{
    public function getRunnerUsersForOrder(string $orderField, string $orderType, array $inputs): Model|Builder;
}
