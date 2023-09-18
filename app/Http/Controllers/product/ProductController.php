<?php

namespace App\Http\Controllers\product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->middleware('auth');
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataProducts = $this->productService->getAllProducts();
        if($request->has('product_code') || $request->has('name')){
            $dataProducts = $this->productService->searchProducts($request);
            if ($dataProducts->isEmpty()) {
                return redirect()->back()->withErrors('Không có người dùng nào phù hợp.');
            }
        }
        return view('products.list-products', compact('dataProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.add-products');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $result = $this->productService->saveProduct($request);
        if ($result) {
            return redirect()->route('products.index')->with('success', 'Thêm sản phẩm mới thành công.');
        } else {
            return redirect()->back()->withErrors('Không thể thêm sản phẩm mới.');
        }
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
        $dataProducts = $this->productService->editProduct($id);
        return view('products.edit-products',compact('dataProducts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $result = $this->productService->updateProducts($request, $id);

        if ($result === true) {
            return redirect()->route('products.index')->with('success', 'Chỉnh sửa sản phẩm thành công.');
        } elseif ($result === 'version_mismatch') {
            return redirect()->route('products.index')->withErrors('Đã có người cập nhật trước đó.');
        } elseif ($result === 'product_not_found') {
            return redirect()->back()->withErrors('Sản phẩm không tồn tại.');
        } else {
            return redirect()->back()->withErrors('Không thể chỉnh sửa sản phẩm.');
        }
        // switch ($result) {
        //     case true:
        //         return redirect()->route('products.index')->with('success', 'Chỉnh sửa sản phẩm thành công.');
        //     case 'version_mismatch':
        //         return redirect()->route('products.index')->withErrors('Đã có người cập nhật trước đó.');
        //     case 'product_not_found':
        //         return redirect()->back()->withErrors('Sản phẩm không tồn tại.');
        //     default:
        //         return redirect()->back()->withErrors('Không thể chỉnh sửa sản phẩm.');
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->productService->deleteProduct($id);
        if($result){
            return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công.');
        }else{
            return redirect()->route('products.index')->with('Xóa sản phẩm thất bại.');
        }
    }
}
