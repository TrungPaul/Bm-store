<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ProductFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function category($cateId)
    {
        return $this->where('category_id', $cateId);
    }

    public function status($status)
    {
        return $this->where('status', $status);
    }

    public function idUserBuy($id)
    {
        return $this->where('id_user_buy', $id);
    }
}
