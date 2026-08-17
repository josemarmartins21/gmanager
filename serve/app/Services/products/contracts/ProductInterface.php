<?php

namespace App\Services\products\contracts;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductInterface
{
    /**
     * Get all products
     * 
     * @return Collection
     * @throws \Exception
     */
    public function all();

    /**
     * Get a product model
     * 
     * @param int $id
     * @return Product
     * @throws \Exception
     */
    public function get(int $id);

    /**
     * Store a new product
     * 
     * @param array $data
     * @return Product
     * @throws \Exception
     */
    public function save($data = []): Product;
    public function update(Product $product, $data = []);
    public function delete(Product $product);
}