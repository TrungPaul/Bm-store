<?php

namespace App\Repositories;

use App\ModelFilters\ProductFilter;
use App\Models\Product;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Criteria\RequestCriteria;


/**
 * Class ProductRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepositoryEloquent implements ProductRepository
{
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->setModelFilter(ProductFilter::class);
    }
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
