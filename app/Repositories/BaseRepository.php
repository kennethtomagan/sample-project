<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class BaseRepository implements BaseRepositoryInterface
{

    /**
     * @var $query Builder
     */
    protected Builder $query;

    /**
     * @var Model
     */
    protected Model $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data) : bool
    {
        return $model->update($data);
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all(array $columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->model->orderBy($orderBy, $sortBy)->get($columns);
    }

    /**
     * @param string $id
     * @return Model
     */
    public function find($id): Model
    {
        return $this->model->find($id);
    }

    /**
     * @param  $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function findBy(array $data): Collection
    {
        return $this->model->where($data)->get();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function findOneBy(array $data): Model
    {
        return $this->model->where($data)->first();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneByOrFail(array $data)
    {
        return $this->model->where($data)->firstOrFail();
    }

    /**
     * @param Model $model
     * @return bool
     * @throws \Exception
     */
    public function delete(Model $model) : bool
    {
        return $model->delete();
    }

    /**
     * Create custom build query
     *
     * @param Builder|Model $modelOrBuilder
     * @param array $params
     * @return Builder
     */
    public function queryBy(Model|Builder $modelOrBuilder, array $params) : Builder
    {
        $start = $modelOrBuilder;
        if (!empty($params)) {
            $start->where($params);
        }

        $this->query = $start;

        return $this->query;
    }
}
