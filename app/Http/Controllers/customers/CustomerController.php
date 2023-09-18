<?php

namespace App\Http\Controllers\customers;

use Illuminate\Http\Request;
use App\Services\CustomerService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->middleware('auth');
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataCustomers = $this->customerService->getAllCustomers();
        if($request->has('name')||$request->has('phone')) {
            $dataCustomers = $this->customerService->searchCustomers($request);
            if ($dataCustomers->isEmpty()) {
                return redirect()->back()->withErrors('Không có người dùng nào phù hợp.');
            }
        }
        return view('customers.list-customers', compact('dataCustomers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.add-customer');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $result = $this->customerService->saveCustomer($request);
        if($result) {
            return redirect()->route('customers.index')->with('success','Thêm mới thành công.');
        }else {
            return redirect()->back()->withErrors('Thêm mới thất bại.');
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
        $dataCustomers = $this->customerService->getDataCustomer($id);
        return view('customers.edit-customer',compact('dataCustomers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $result = $this->customerService->updateCustomer($request,$id);
        if ($result === true) {
            return redirect()->route('customers.index')->with('success', 'Chỉnh sửa thông tin khách hàng thành công.');
        } elseif ($result === 'version_mismatch') {
            return redirect()->route('customers.index')->withErrors('Đã có người cập nhật trước đó.');
        } elseif ($result === 'product_not_found') {
            return redirect()->back()->withErrors('Khách hàng không tồn tại không tồn tại.');
        } elseif ($result === 'phone_duplicate'){
            return redirect()->back()->withErrors('Số điện thoại bị trùng lặp.');
        }else {
            return redirect()->back()->withErrors('Không thể chỉnh sửa thông tin khách hàng.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->customerService->deleteCustomer($id);
        if($result) {
            return redirect()->route('customers.index')->with('success','Xóa thành công');
        }else {
            return redirect()->back()->withErrors('Xóa không thành công');
        }
    }
}
