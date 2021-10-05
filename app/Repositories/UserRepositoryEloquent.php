<?php

namespace App\Repositories;

use App\ModelFilters\UserFilter;
use App\Models\User;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepositoryEloquent implements UserRepository
{
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->setModelFilter(UserFilter::class);
    }

    public function model()
    {
        return User::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
