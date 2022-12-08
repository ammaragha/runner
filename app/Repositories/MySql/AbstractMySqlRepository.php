<?php

namespace App\Repositories\MySql;

use App\Repositories\Contracts\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class AbstractMySqlRepository implements BaseRepository
{

    public function __construct(
        protected Model $model // prepare model wich query on
    ) {
    }

    /**
     * just return Model
     */
    public function make(Model|Builder $model = null): Model|Builder
    {
        if ($model) {
            $this->model = $model;
        }

        return $this->model;
    }

    /**
     * prepare order by
     * @param string $orderType
     * @param string $orderField
     * @return Builder
     */
    public function orderBy(Model|Builder $model, $orderField, $orderType): Builder
    {
        if (!is_null($orderType) && !is_null($orderField)) {
            $result =  $model->orderBy($orderField, $orderType);
        } else {
            $result = $model;
        }

        return $result;
    }

    /**
     * retrive all data
     * @param string $roderType
     * @param string $orderField
     * @param array $cols
     * @return Collection
     */
    public function all($orderField = null, $orderType = null, array $cols = []): Collection
    {
        $model = $this->model;
        $ordered = $this->orderBy($model, $orderField, $orderType);
        return count($cols) > 0 ? $ordered->get($cols) : $ordered->get();
    }


    /**
     * return data in pagination 
     * @param int $perPage
     * @param string $roderType
     * @param string $orderField
     * @return LengthAwarePaginator
     */
    public function pagination(int $perPage, $orderField = null, $orderType = null): LengthAwarePaginator
    {
        $model = $this->model;
        $ordered = $this->orderBy($model, $orderField, $orderType);
        return $ordered->paginate($perPage);
    }

    /**
     * return data in search 
     * @param string $searchKey
     * @param string $searchValue
     * @param string $roderType
     * @param string $orderField
     */
    public function search(string $searchKey, string $searchValue, $orderField = null, $orderType = null): model|Builder
    {
        $model = $this->model;
        $searched = $model->where($searchKey, "LIKE", "%" . $searchValue . "%");
        return $this->orderBy($searched, $orderField, $orderType);
    }

    /**
     * find by id
     * @param int $id
     * @return Model|null
     */
    public function findById(int $id): Model|null
    {
        return $this->model->find($id);
    }

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
    public function findBy($key, $value, $op = "=", int $limit = null, $orderField = null, $orderType = null, array $cols = []): Model|Collection
    {
        $model = $this->model->where($key, $op, $value);
        $ordered = $this->orderBy($model, $orderField, $orderType);
        if ($limit) {
            if ($limit == 1) {
                return count($cols) > 0 ? $ordered->first($cols) : $ordered->first();
            } else {
                return count($cols) > 0 ? $ordered->limit($limit)->get($cols) :  $ordered->limit($limit)->get();
            }
        } else {
            return count($cols) > 0 ? $ordered->get($cols) :  $ordered->get();
        }
    }


    /**
     * save new
     * @param array $inputs
     * @return Model
     */
    public function save(array $inputs): Model
    {
        $saved = $this->model->create($inputs);
        return $saved;
    }

    /**
     * update record
     * @param Model $model
     * @param array $inputs
     * @return bool
     */
    public function update(Model $model, array $inputs): bool
    {
        $updated = $model->update($inputs);
        return $updated;
    }

    /**
     * delete record
     * @param Model $model
     * @return bool|null
     */
    public function delete(Model $model): bool|null
    {
        $deleted = $model->delete();
        return $deleted;
    }
}
