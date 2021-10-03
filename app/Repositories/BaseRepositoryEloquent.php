<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository as L5BaseRepository;
/**
 * Class BaseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
abstract class BaseRepositoryEloquent extends L5BaseRepository
{
    const PER_PAGE = 20;

    private $modelFilter;

    protected function getModelFilter() : ?string
    {
        return $this->modelFilter;
    }

    protected function setModelFilter(string $modelFilter) :self
    {
        $this->modelFilter = $modelFilter;

        return $this;
    }

    public function find($id, $columns = ['*'], array $with = [])
    {
        $this->model = $this->model->with($with);

        return parent::find($id, $columns = ['*']);
    }

    public function all($columns = ['*'], array $relations = [])
    {
        $this->model = $this->model->with($relations);

        return parent::all($columns);
    }

    public function findWhereIn($field, array $values, $columns = ['*'], array $with = [])
    {
        $this->model = $this->model->with($with);

        return parent::findWhereIn($field, $values, $columns);
    }

    public function findWhere(array $where, $columns = ['*'], array $with = [])
    {
        $this->model = $this->model->with($with);

        return parent::findWhere($where, $columns);
    }

    public function getAllWithConditions(array $where = [], array $column = ['*'], string $order = 'DESC', string $orderBy = 'id', array $with = [],  bool $paginate = true)
    {
        $this->applyCriteria();
        $this->applyScope();

        $query = $this->model;

        if (!empty($where)) {
            $query = $query->where($where);
        }

        if (!empty($column)) {
            $query = $query->select($column);
        }

        $query = $query->orderBy($orderBy, $order)->with($with);

        if ($paginate) {
            $perPage = $this->app['request']->input('per_page') ?? self::PER_PAGE;

            $query = $query->paginate($perPage);
        } else {
            $query = $query->get();
        }

        $this->resetModel();

        return $this->parserResult($query);
    }

    public function getAllWithFilter(array $filters = [], array $with = [], string $order = 'DESC', string $orderBy = 'id', bool $paginate = true)
    {
        $query = $this->filter($filters, $this->getModelFilter());
        $query = $query->orderBy($orderBy, $order)->with($with);

        if ($paginate) {
            $perPage = $this->app['request']->input('per_page') ?? self::PER_PAGE;

            $query = $query->paginate($perPage);
        } else {
            $query = $query->get();
        }

        $this->resetModel();

        return $this->parserResult($query);
    }

    public function filter(array $filters, ?string $modelFilter)
    {
        $this->applyCriteria();
        $this->applyScope();

        if ($modelFilter) {
            return $this->model->filter($filters, $modelFilter);
        }

        return $this->model;
    }

    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    public function test()
    {
        return "test";
    }
}
