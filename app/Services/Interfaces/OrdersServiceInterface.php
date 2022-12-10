<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface OrdersServiceInterface
{
    public function findRunners(array $inputs): Collection;
}
