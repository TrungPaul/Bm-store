<?php

namespace App\Services;

use App\Repositories\CategoryRepositoryEloquent;

class CategoryService extends BaseService
{
    protected $repository;

    public function __construct(CategoryRepositoryEloquent $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }

    public function create(array $attributes)
    {
        return $this->repository->create($attributes);
    }

    public function preparingCreateOrUpdate(array $attribute)
    {
        return $attribute;
    }

//    public function update(array $attributes, int $id)
//    {
//        return $this->repository->update($attributes, $id);
//    }

    public function functionInService()
    {
        return $this->repository->funcInRepositoryEloquent();
    }
}
