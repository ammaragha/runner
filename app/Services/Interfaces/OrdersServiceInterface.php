<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface OrdersServiceInterface
{
    public function findRunner(int $limit,array $inputs): LengthAwarePaginator;
    public function recent(int $limie, string $role, int $id, array $inputs): Collection;
}
