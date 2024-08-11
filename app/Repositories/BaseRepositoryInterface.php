<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data) : bool;

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all(array $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc');

    /**
     * @param $id
     * @return Model
     */
    public function find($id): Model;

    /**
     * @param $id
     * @return mixed
     */
    public function findOneOrFail($id);

    /**
     * @param array $data
     * @return Collection
     */
    public function findBy(array $data): Collection;

    /**
     * @param array $data
     * @return Model
     */
    public function findOneBy(array $data): Model;

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneByOrFail(array $data);

    /**
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model) : bool;
}
