<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * get all data products.
     */
     public function getAllProducts()
     {
        $dataProducts = $this->productRepository->getAllProducts();
        return $dataProducts;
     }

     /**
     * insert products.
     */
    public function saveProduct($request)
    {
        DB::beginTransaction();
        try {
            $today = now()->format('Y-m-d H:i:s');
            $data = [
                    'product_code' => $request->product_code,
                    'name' => $request->name,
                    'price_sell' => $request->price_sell,
                    'price_buy' => $request->price_buy,
                    'quantity' => $request->quantity,
                    'created_at'=> $today,
                    'version'=> 1
                ];
            $result = $this->productRepository->save($data);
            if ($result) {
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return false;
        }
    }

    /**
     * get data edit form products.
     */
    public function editProduct($productId)
    {
        $dataProducts = $this->productRepository->editProduct($productId);
        return $dataProducts;
    }

     /**
     * update products.
     */
    public function updateProducts($request,$productId)
    {
        DB::beginTransaction();
        try {
            $today = now()->format('Y-m-d H:i:s');
            $product = DB::table('products')->where('id',$productId)->first();
            if ($product) {
                $currentVersion = $product->version;
                if ($currentVersion == $request->version) {
                    $data = [
                        'product_code' => $request->product_code,
                        'name' => $request->name,
                        'price_sell' => $request->price_sell,
                        'price_buy' => $request->price_buy,
                        'updated_at' => $today,
                        'version' => $currentVersion + 1,
                    ];
                    $result = $this->productRepository->update($data, $productId);
                    if ($result) {
                        DB::commit();
                        return true;
                    } else {
                        DB::rollBack();
                        return false;
                    }
                } else {
                    DB::rollBack();
                    return 'version_mismatch';
                }
            }
            DB::rollBack();
            return 'product_not_found';
        } catch (\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }

     /**
     * delete products.
     */
    public function deleteProduct($productId)
    {
        DB::beginTransaction();
        try {
            $result = $this->productRepository->delete($productId);
            if ($result) {
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        }catch(\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }

    /**
     * search products.
     */
    public function searchProducts($request)
    {
        $dataProducts = $this->productRepository->searchProducts($request);
        return $dataProducts;
    }
}
