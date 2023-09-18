<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
Class OrderRepository
{
    public function allDataOrders()
    {
        return $this->queryOrders()->orderBy('orders.date_order','desc')->paginate(10);
    }

    public function orderSearch($request)
    {
        return $this->queryOrders()->where(function($q) use($request){
                                        if(!empty($request->username)){
                                            $q->where('users.username', $request->username);
                                        }
                                        if(!empty($request->name_staff)){
                                            $q->where('users.name_staff', $request->name_staff);
                                        }
                                        if(!empty($request->product_code)){
                                            $q->where('products.product_code', $request->product_code);
                                        }
                                        if(!empty($request->product_name)){
                                            $q->where('products.name', $request->product_name);
                                        }
                                        if(!empty($request->customer_name)){
                                            $q->where('customers.name', $request->customer_name);
                                        }
                                        if(!empty($request->phone)){
                                            $q->where('customers.phone', $request->phone);
                                        }
                                        if(!empty($request->date_order)){
                                            $q->where('orders.date_order', $request->date_order);
                                        }
                                        if(!empty($request->date_allocation)){
                                            $q->where('orders.date_allocation', $request->date_allocation);
                                        }
                                    })
                                    ->orderBy('orders.date_order','desc')->paginate(10);

                                // if(!empty($request->username)){
                                //     $model->where('users.username', $request->username);
                                // }
                                // if(!empty($request->name_staff)){
                                //     $model->where('users.name_staff', $request->name_staff);
                                // }
                                // if(!empty($request->product_code)){
                                //     $model->where('products.product_code', $request->product_code);
                                // }
                                // if(!empty($request->product_name)){
                                //     $model->where('products.name', $request->product_name);
                                // }
                                // if(!empty($request->customer_name)){
                                //     $model->where('customers.name', $request->customer_name);
                                // }
                                // if(!empty($request->customer_phone)){
                                //     $model->where('customers.phone', $request->customer_phone);
                                // }
                                // if(!empty($request->date_order)){
                                //     $model->where('orders.date_order', $request->date_order);
                                // }
                                // if(!empty($request->date_allocation)){
                                //     $model->where('orders.date_allocation', $request->date_allocation);
                                // }
    }
    public function queryOrders()
    {
        return DB::table('orders')->join('products', 'orders.product_id', '=', 'products.id')
                                    ->join('customers', 'orders.customer_id', '=', 'customers.id')
                                    ->join('users', 'orders.user_id', '=', 'users.id')
                                    ->select(
                                        'orders.id',
                                        'orders.date_order',
                                        'products.product_code',
                                        'products.name as product_name',
                                        'products.price_sell',
                                        'orders.quantity',
                                        'customers.name as customer_name',
                                        'customers.id as customer_id',
                                        'products.id as product_id',
                                        'customers.phone',
                                        'customers.address',
                                        'orders.status',
                                        'orders.version',
                                        'orders.date_allocation',
                                        'users.username',
                                        'users.name_staff'
                                    );
    }
    public function saveOrder(array $data)
    {
        return DB::table('orders')->insert($data);
    }

    public function updateOrder($data,$orderId)
    {
        return DB::table('orders')->where('id',$orderId)->update($data);
    }
}
