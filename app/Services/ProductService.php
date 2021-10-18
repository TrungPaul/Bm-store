<?php

namespace App\Services;

use App\Repositories\ProductRepositoryEloquent;

class ProductService extends BaseService
{
    public function __construct(ProductRepositoryEloquent $productRepositoryEloquent)
    {
        $this->repository = $productRepositoryEloquent;
    }

    public function preparingCreate(array $attributes)
    {
        $attributes['name_user'] = now();
        $data = $attributes['data'];
        // cut data line by line
        $products = explode("\n", $data);
        $array[] = [];

        foreach ($products as $key => $product) {
            // remove key in array
            unset($attributes['_token']);
            $id_fb = explode('/', $product)[0];
            $array[$key] = $attributes; // data request post
            $array[$key]['id_fb'] = $id_fb;
            $array[$key]['data'] = $product;
            $array[$key]['date'] = now();
            $array[$key]['date_sell'] = 1;
        }

        return $array;
        // structured data below:
        /* $array = [
             [
               'id_fb' => 1,
               'data' => 1/2/3/4,
               ...
             ],
             [
               'id_fb' => 4,
               'data' => 4/5/3/4,
               ...
             ],
            ...
        ]*/
    }
}
