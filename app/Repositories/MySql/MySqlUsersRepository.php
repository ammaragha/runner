<?php

namespace App\Repositories\MySql;

use App\Repositories\Contracts\UsersRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MySqlUsersRepository extends AbstractMySqlRepository implements UsersRepository
{
    public function getUsersWithState(string $state): Model|Builder
    {
        $users = $this->model->whereHas('addresses', function (Builder $q) use ($state) {
            $q->where('state', $state);
        });
        return $users;
    }
}
