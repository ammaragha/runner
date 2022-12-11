<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface OrdersServiceInterface
{
    public function findRunner(array $inputs): Collection;
}
