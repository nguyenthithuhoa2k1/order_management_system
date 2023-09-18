<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{

    /**
     * get all data products.
     */
    public function getAllProducts()
    {
       return DB::table('products')->paginate(20);
    }

    /**
     * insert products.
     */
    public function save(array $data)
    {
        return DB::table('products')->insert($data);
    }

    /**
     * get data edit form products.
     */
    public function editProduct($productId)
    {
        return DB::table('products')->where('id',$productId)->get();
    }

    /**
     * update products.
     */
    public function update(array $data,$productId)
    {
        return DB::table('products')->where('id',$productId)->update($data);
    }

    /**
     * delete products.
     */
    public function delete($productId)
    {
        return DB::table('products')->where('id',$productId)->delete();

    }

    /**
     * search products.
     */
    public function searchProducts($request)
    {
        return DB::table('products')->where('product_code',$request->product_code)
        ->orWhere('name',$request->name)->get();
    }
}
