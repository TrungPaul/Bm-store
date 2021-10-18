<?php

namespace App\Services;

use App\Repositories\OrderRepositoryEloquent;

class OrderService extends BaseService
{
    protected $repository;

    public function __construct(OrderRepositoryEloquent $orderRepositoryEloquent)
    {
        $this->repository = $orderRepositoryEloquent;
    }
}
