<?php

namespace App\Http\Controllers\orders;

use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->middleware('auth');
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allDataOrders = $this->orderService->allDataOrders();
        if($request){
            $allDataOrders = $this->orderService->orderSearch($request);
        }
        return view('orders.index', compact('allDataOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function orderInsert(Request $request)
    {
        $getDataOrders = $request->all();
        $order_new = isset($getDataOrders['getDataOrders']['order_new']) ? $getDataOrders['getDataOrders']['order_new'] : null;
        $order_update = isset($getDataOrders['getDataOrders']['order_update']) ? $getDataOrders['getDataOrders']['order_update'] : null;
        if($order_new){
            foreach($order_new as $orderId => $value) {
                $result = $this->orderService->saveOrder($orderId,$value);
            }
            if($result){
                return response()->json(['success'=>'Lưu thành công']);
            }else{
                return response()->json(['errors'=>'Không thể lưu orders.']);
            }
        }
        if($order_update){
            foreach($order_update as $orderId => $value) {
                $result = $this->orderService->updateOrder($orderId,$value);
            }
            if ($result === true) {
                return response()->json(['success'=>'Cập nhật thành công']);
            } elseif ($result === 'version_mismatch') {
                return response()->json(['errors'=>'Đã có người cập nhật trước đó.']);
            } elseif ($result === 'order_not_found') {
                return response()->json(['errors'=>'orders không tồn tại.']);
            } else {
                return response()->json(['errors'=>'Không thể chỉnh sửa orders.']);
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
