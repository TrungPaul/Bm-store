<?php

namespace App\Services;

use App\Repositories\UserRepositoryEloquent;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    protected $repository;

    public function __construct(UserRepositoryEloquent $userRepositoryEloquent)
    {
        $this->repository = $userRepositoryEloquent;
    }

    public function preparingCreateOrUpdate(array $attribute)
    {
        if (isset($attribute['type'])  == "CHANGE_PASS")
        {
            unset($attribute['type']);
            $attribute['password'] = Hash::make($attribute['password']);
        }

        return $attribute;
    }
}
