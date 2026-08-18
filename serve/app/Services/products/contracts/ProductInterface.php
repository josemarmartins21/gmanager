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
     * Store a new product record
     * 
     * @param array $data
     * @return Product
     * @throws \Exception
     */
    public function save($data = []): Product;

    /**
     * Update a product record
     * 
     * @param array $data
     * @param Product $product
     * @return void
     * @throws \Exception
     */
    public function update(Product $product, $data = []);

    /**
     * @param Product
     * 
     * @throws \Exception
     * @return void
     */
    public function delete(Product $product);
}