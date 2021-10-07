<?php

namespace App\Repositories;

use App\Models\Product;
use Prettus\Repository\Criteria\RequestCriteria;


/**
 * Class ProductRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepositoryEloquent implements ProductRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
