<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.login');
    }

    /**
     * login.
     */
    public function login(Request $request)
    {
        $login = [
            'username'=>$request->username,
            'password'=>$request->password,
        ];
        if (Auth::attempt($login)) {
            return redirect()->route('customers.index')->with('success', 'Login success.');
        } else {
            return redirect()->back()->withErrors('Login failed. Please check your credentials.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Logout successful.');
        } else {
            return redirect()->back()->withErrors('Logout failed. You were not logged in.');
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
