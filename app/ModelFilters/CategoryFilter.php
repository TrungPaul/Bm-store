<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class CategoryFilter extends ModelFilter
{
    public function key($key)
    {
         return $this->where(function($q) use ($key) {
             return $q->where('name', 'LIKE', '%' . $key . '%')
                ->orWhere('description', 'LIKE', '%' . $key . '%');
        });
    }
}
