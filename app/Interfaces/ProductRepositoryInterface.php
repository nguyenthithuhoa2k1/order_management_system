<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAllProducts();
    public function save(array $data);
    public function editProduct($productId);
    public function update(array $data,$productId);
    public function delete($productId);
    public function searchProducts($request);
}

