<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;

Class OrderService
{
    protected $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function allDataOrders()
    {
        return $this->orderRepository->allDataOrders();

    }

    public function orderSearch($request)
    {
        return $this->orderRepository->orderSearch($request);
    }
    public function saveOrder($orderId,$value)
    {
        DB::beginTransaction();
        try{
            $today = now()->format('Y-m-d H:i:s');
            $user_id = Auth::id();
            $data = [
                'product_id'=>$value['product_id'],
                'customer_id'=>$value['customer_id'],
                'user_id'=>$user_id,
                'date_order'=>$value['date_order'],
                'quantity'=>$value['quantity'],
                'status'=>1,
                'created_at'=> $today,
            ];
            $result = $this->orderRepository->saveOrder($data);
            if($result){
                DB::commit();
                return true;
            }else{
                dd(111);
                DB::rollBack();
                return false;
            }
        }catch(\Throwable $e){
            dd($e);
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }

    public function updateOrder($orderId,$value)
    {
        $user_id = Auth::id();
        DB::beginTransaction();
        try {
            $today = now()->format('Y-m-d H:i:s');
            $orders = DB::table('orders')->where('id',$orderId)->first();
            if($orders){
                $currentVersion = $orders->version;
                if($currentVersion === (int)$value['version']){
                    $data = [
                        'user_id' => $user_id,
                        'status' => 1,
                        'version' => $currentVersion + 1,
                        'quantity' => isset($value['quantity']) ? $value['quantity'] : $orders->quantity,
                        'date_order' => isset($value['date_order']) ? $value['date_order'] : $orders->date_order,
                        'customer_id' => isset($value['customer_id']) ? $value['customer_id'] : $orders->customer_id,
                        'product_id' => isset($value['product_id']) ? $value['product_id'] : $orders->product_id,
                        'updated_at' => $today
                    ];
                    $result = $this->orderRepository->updateOrder($data,$orderId);
                    if($result){
                        DB::commit();
                        return true;
                    }else{
                        DB::rollBack();
                        return false;
                    }
                }else{
                    DB::rollBack();
                    return 'version_mismatch';
                }
            }
            DB::rollBack();
            return 'product_not_found';
        }catch(\Throwable $e){
            dd($e);
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }
}
