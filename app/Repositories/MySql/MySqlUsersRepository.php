<?php

namespace App\Repositories\MySql;

use App\Repositories\Contracts\UsersRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MySqlUsersRepository extends AbstractMySqlRepository implements UsersRepository
{
    public function getRunnerUsersForOrder(string $orderField=null, string $orderType=null, array $inputs): Model|Builder
    {
        $state = $inputs['state'];
        $min_cost = $inputs['min_cost'];
        $max_cost = $inputs['max_cost'];

        $users = $this->model
            ->join("addresses","addresses.user_id","=","users.id")
            ->join("runners","runners.user_id","=","users.id")
            ->where("addresses.state",$state)
            ->where("runners.is_active",true)
            ->whereBetween("cost_per_hour",[$min_cost,$max_cost]);
        
        $users = $this->orderBy($users,$orderField,$orderType);
        return $users;
    }
}
