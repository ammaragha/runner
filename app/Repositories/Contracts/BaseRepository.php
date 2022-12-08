<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BaseRepository
{
    /**
     * prepare order by
     * @param Model $model
     * @param string $orderType
     * @param string $orderField
     * @return Builder
     */
    public function orderBy(Model $model, $orderType, $orderField): Builder;

    /**
     * retrive all data
     * @param string $roderType
     * @param string $orderField
     * @param array $cols
     * @return Collection
     */
    public function all($orderType = null, $orderField = null, array $cols = []): Collection;

    /**
     * return data in pagination 
     * @param int $perPage
     * @param string $roderType
     * @param string $orderField
     */
    public function pagination(int $perPage, $orderType = null, $orderField = null): LengthAwarePaginator;

    /**
     * find by id
     * @param int $id
     * @return Model|null
     */
    public function findById(int $id): Model|null;

    /**
     * find by any
     * @param $key
     * @param $value
     * @param $op
     * @param $limit 
     * @param $orderType
     * @param $orderField
     * @param array $cols
     * @return Model|Collection
     */
    public function findBy($key, $value, $op = "=", int $limit = null, $orderType = null, $orderField = null, array $cols = []): Model|Collection;

    /**
     * save new
     * @param array $inputs
     * @return Model
     */
    public function save(array $inputs): Model;

    /**
     * update record
     * @param Model $model
     * @param array $inputs
     * @return bool
     */
    public function update(Model $model, array $inputs): bool;

    /**
     * delete record
     * @param Model $model
     * @return bool|null
     */
    public function delete(Model $model): bool|null;
}
