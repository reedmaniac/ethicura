<?php

namespace App\Services;

use App\Models\Product;

class ProductsService
{
    /**
     * Create new Product
     *
     * @param array $params
     * @return Product
     */
    public function create($params)
    {
        return Product::create($params);
    }
}
