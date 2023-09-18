<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataUsers = $this->userService->getAllUsers();
        if($request->has('username') || $request->has('name_staff') || $request->has('phone')){
            $dataUsers = $this->userService->seachUsers($request);
            if ($dataUsers->isEmpty()) {
                return redirect()->back()->withErrors('Không có người dùng nào phù hợp.');
            }
        }
        return view('admin.users.list-users', compact('dataUsers'));
    }

    /**
     * show form register users.
     */
    public function showFormRegisterUser()
    {
        return view('admin.register-users');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $result = $this->userService->saveUser($request);
        if ($result) {
            return redirect()->route('users')->with('success', 'Thêm sản phẩm mới thành công.');
        } else {
            return redirect()->back()->withErrors('Không thể thêm sản phẩm mới.');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dataUsers = $this->userService->editUser($id);
        return view('admin.users.edit-users', compact('dataUsers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $result = $this->userService->updateUser($request, $id);

        if ($result === true) {
            return redirect()->route('users')->with('success', 'Chỉnh sửa sản phẩm thành công.');
        } elseif ($result === 'version_mismatch') {
            return redirect()->route('users')->withErrors('Đã có người cập nhật trước đó.');
        } elseif ($result === 'user_not_found') {
            return redirect()->back()->withErrors('Sản phẩm không tồn tại.');
        } else {
            return redirect()->back()->withErrors('Không thể chỉnh sửa sản phẩm.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->userService->deleteUser($id);
        if($result) {
            DB::commit();
            return redirect()->route('users')->with('success','Xóa thành công');
        }else {
            return redirect()->back()->withErrors('Xóa không thành công');
        }
    }
}
