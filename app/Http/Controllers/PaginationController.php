<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaginationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pagination(Request $request)
    {
        if($request->pagination1){
            $pagination = $request->pagination1[-1];
            if($request->dataProceed == 'dataNextPage1'){
                $page1 = $pagination;
            }
            if($request->dataProceed == 'dataPreviousPage1'){
                $page1 = $pagination - 1;
                if($page1 < 2 ){
                    $page1 = 1;
                }
            }
        }
        return response()->json(['page1'=>$page1]);
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
        //
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
