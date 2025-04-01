<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Arr;

class ProductsService
{
    /**
     * Create new Product
     *
     * @param array $params
     * @return Product
     */
    public function create(array $params): Product
    {
        return Product::create($params);
    }

    /**
     * Update Product data
     *
     * @param Product $product
     * @param array $params
     * @return Product
     */
    public function update(Product $product, array $params): Product
    {
        $product->update($params);

        // $product->certifications()->sync(Arr::get($params, 'certification_ids'));
        // $product->packaging()->sync(Arr::get($params, 'packaging_ids'));

        $product->refresh();

        return $product;
    }
}
