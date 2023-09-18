<?php

namespace App\Http\Controllers\orders;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\OrderSearchService;

class SearchController extends Controller
{
    protected $orderSearchService;
    public function __construct(OrderSearchService $OrderSearchService)
    {
        $this->middleware('auth');
        $this->orderSearchService = $OrderSearchService;
    }

    public function searchProductCode(Request $request)
    {
        $result = $this->orderSearchService->searchProductCode($request);
        if($result){
            return response()->json(['result' => $result]);
        }else{
            return response()->json(['result' => ""]);
        }
    }
    public function searchProductName(Request $request)
    {
        $result = $this->orderSearchService->searchProductName($request);
        if($result){
            return response()->json(['result' => $result]);
        }else{
            return response()->json(['result' => ""]);
        }
    }
    public function searchCustomerName(Request $request)
    {
        $result = $this->orderSearchService->searchCustomerName($request);
        if($result){
            return response()->json(['result' => $result]);
        }else{
            return response()->json(['result' => ""]);
        }
    }
    public function searchCustomerPhone(Request $request)
    {
        $result = $this->orderSearchService->searchCustomerPhone($request);
        if($result){
            return response()->json(['result' => $result]);
        }else{
            return response()->json(['result' => ""]);
        }
    }
}
