<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Interfaces\OrderSearchRepositoryInterface;
Class OrderSearchRepository implements OrderSearchRepositoryInterface
{
    public function searchProductCode($request)
    {
        return DB::table('products')->select('name','id','price_sell')->where('product_code',$request->product_code)->first();
    }
    public function searchProductName($request){
        return DB::table('products')->select('product_code','id','price_sell')->where('name',$request->product_name)->first();
    }
    public function searchCustomerName($request)
    {
        return DB::table('customers')->select('phone','id','address')->where('name',$request->customer_name)->first();
    }
    public function searchCustomerPhone($request)
    {
        return DB::table('customers')->select('name','id','address')->where('phone',$request->phone)->first();
    }
    public function searchUserId($request)
    {

        return DB::table('users')->select('name_staff','id')->where('username',$request->username)->first();
    }
}
