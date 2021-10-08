<?php

namespace App\Repositories;

use App\ModelFilters\CategoryFilter;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Category;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepositoryEloquent implements CategoryRepository
{
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->setModelFilter(CategoryFilter::class);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function funcInRepositoryEloquent()
    {
        // mã thực thi
        return "code run";
    }
}
