<?php

namespace App\Services\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface OrdersServiceInterface
{
    public function findRunner(array $inputs): LengthAwarePaginator;
}
