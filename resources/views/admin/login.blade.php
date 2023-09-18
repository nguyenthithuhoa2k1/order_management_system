@extends('admin.layout.master')
@section('content')
    <form class="login" method="POST" action="{{url('login')}}">
        @csrf
        <h1>hệ thống đặt hàng</h1>
        <input type="text" name="username" placeholder="Tài khoản" value="{{old('username')}}">
        <input type="text" name="password" placeholder="Mật khẩu" value="{{old('password')}}">
        <x-errors/>
        <x-success/>
        <button type="submit">Đăng nhập</button>
    </form>
@endsection
