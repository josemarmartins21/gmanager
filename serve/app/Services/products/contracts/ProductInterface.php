<?php

namespace App\Services\products\contracts;

use App\Models\Product;

interface ProductInterface
{
    /**
     * Get all products
     * 
     */
    public function all();

    /**
     * 
     */
    public function get(int $id);

    /**
     * 
     */
    public function save($data = []);
    public function update(Product $product, $data = []);
    public function delete(Product $product);
}