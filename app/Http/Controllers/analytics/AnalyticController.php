<?php

namespace App\Http\Controllers\Analytics;

use App\Services\AnalyticService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AnalyticController extends Controller
{

    protected $analyticService;
    public function __construct(AnalyticService $analyticService)
    {
        $this->middleware('auth');
        $this->analyticService = $analyticService;
    }
    /**
     * Display a listing of the resource.
     */
    public function getDataAnalytics(Request $request)
    {
        $data = $this->analyticService->getDataAnalytics($request);
        return view('analytics.index', ['data'=>$data]);
    }

    public function fetchDataCustomer(Request $request) {
        $data = $this->analyticService->fetchDataCustomer($request);
        return response()->json([
            'data' => $data
        ]);
    }

    public function fetchDataProductIdBestSeller(Request $request) {
        $data = $this->analyticService->fetchDataProductIdBestSeller($request);
        return response()->json([
            'data' => $data
        ]);
    }

    public function fetchDataProduct(Request $request) {
        $data = $this->analyticService->fetchDataProduct($request);
        return response()->json([
            'data' => $data
        ]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
