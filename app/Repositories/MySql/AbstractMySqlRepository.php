<?php

namespace App\Repositories\MySql;

use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractMySqlRepository implements BaseRepository
{

    public function __construct(
        protected Model $model // prepare model wich query on
    ) {
    }

    /**
     * prepare order by
     * @param string $orderType
     * @param string $orderField
     * @return Model
     */
    public function orderBy(Model $model, $orderType, $orderField): Model
    {
        if (!is_null($orderType) && !is_null($orderField)) {
            $result =  $model->orderBy($orderType, $orderField);
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
    public function all($orderType = null, $orderField = null, array $cols = []): Collection
    {
        $model = $this->model;
        $ordered = $this->orderBy($model, $orderType, $orderField);
        return count($cols) > 0 ? $ordered->get($cols) : $ordered->get();
    }


    /**
     * return data in pagination 
     * @param int $perPage
     * @param string $roderType
     * @param string $orderField
     * @return Collection
     */
    public function pagination(int $perPage, $orderType = null, $orderField = null): Collection
    {
        $model = $this->model;
        $ordered = $this->orderBy($model, $orderType, $orderField);
        return $ordered->pagination($perPage);
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
    public function findBy($key, $value, $op = "=", int $limit = null, $orderType = null, $orderField = null, array $cols = []): Model|Collection
    {
        $model = $this->model->where($key, $op, $value);
        $ordered = $this->orderBy($model, $orderType, $orderField);
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
