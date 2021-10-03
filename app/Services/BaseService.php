<?php

namespace App\Services;
use App\Repositories\BaseRepositoryEloquent;

abstract class BaseService
{
    /** @var BaseRepositoryEloquent */
    protected $repository;

    public function all(array $columns = ['*'], array $relations = [])
    {
        return $this->repository->all($columns, $relations);
    }

    public function count(array $where = [], $columns = '*')
    {
        return $this->repository->count($where, $columns);
    }

    public function paginate(array $with = [], int $limit = 15, array $columns = ['*'])
    {
        return $this->repository->orderBy('id', 'DESC')->with($with)->paginate($limit, $columns);
    }

    public function find(int $id, array $columns = ['*'], array $with = [])
    {
        return $this->repository->find($id, $columns, $with);
    }

    public function findByField(string $field, $value, array $columns = ['*'])
    {
        return $this->repository->findByField($field, $value, $columns);
    }

    public function findWhere(array $where, $columns = ['*'], array $with = [])
    {
        return $this->repository->findWhere($where, $columns, $with);
    }

    public function findWhereIn(string $field, array $values, $columns = ['*'], array $with = [])
    {
        return $this->repository->findWhereIn($field, $values, $columns, $with);
    }

    public function create(array $attributes)
    {
        return $this->repository->create($attributes);
    }

    public function update(array $attributes, int $id)
    {
        return $this->repository->update($attributes, $id);
    }

    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->repository->updateOrCreate($attributes, $values);
    }

    public function getAllWithFilter(array $filters = [], array $with = [], string $order = 'DESC',
                                     string $orderBy = 'id', bool $paginate = true)
    {
        return $this->repository->getAllWithFilter($filters, $with, $order, $orderBy, $paginate);
    }

    public function getByConditions(
        array $conditions = [],
        array $with = [],
        string $order = 'DESC',
        string $orderBy = 'id'
    ) {
        return $this->repository->getAllWithFilter($conditions, $with, $order, $orderBy, true);
    }

    public function getAllWithConditions(array $where = [], array $column = ['*'], string $order = 'DESC', string $orderBy = 'id', array $with)
    {
        return $this->repository->getAllWithConditions($where, $column, $order, $orderBy, $with);
    }

    public function insert(array $data)
    {
        return $this->repository->insert($data);
    }
}
