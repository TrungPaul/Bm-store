<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    public function key($key)
    {
        return $this->where(function($q) use ($key) {
            return $q->where('name', 'LIKE', '%' . $key . '%')
                ->orWhere('email', 'LIKE', '%' . $key . '%')
                ->orWhere('phone', 'LIKE', '%' . $key . '%');
        });
    }
}
