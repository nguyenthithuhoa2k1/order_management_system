@extends('admin.layout.master')
@section('content')
    <form method="POST" class="form" action="{{url('edit/users/'.request()->route('id'))}}">
        <x-errors/>
        <x-success/>
        @csrf
        @foreach($dataUsers as $users)
            <h1 class="title">Chỉnh sửa nhân viên</h1>
            <input class="input" type="hidden" name="version" value="{{$users->version}}">
            <div>
                <span>Tên đăng nhập (*)</span>
                <input class="input" type="text" name="username" value="{{old('username') ?? $users->username}}">
            </div>
            <div>
                <span>Mật khẩu (*)</span>
                <input class="input" type="text" name="password" id="password" value="{{old('password')}}">
            </div>
            <div>
                <span>Xác nhận mật khẩu (*)</span>
                <input class="input" type="text" name="password_confirm" value="{{old('password_confirm')}}">
            </div>
            <div>
                <span>Tên nhân viên (*)</span>
                <input class="input" type="text" name="name_staff" value="{{old('name_staff') ?? $users->name_staff}}">
            </div>
            <div>
                <span>Số điện thoại (*)</span>
                <input class="input" type="text" name="phone" value="{{old('phone') ?? $users->phone}}">
            </div>
        @endforeach
        <button type="submit">Chỉnh sửa</button>
    </form>
    <script>
        $(document).ready(function(){
            $('.register').validate({
                rules:{
                    username: {
                        required: true,
                        minlength: 2
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        pwcheck: true
                    },
                    password_confirm: {
                        required: true,
                        minlength: 8,
                        equalTo: "#password"
                    },
                    name_staff: {
                        required: true
                    },
                    phone: {
                        required: true,
                        number: true,
                        minlength: 11
                    },
                },
                messages:{
                    username:{
                        required: "Vui lòng nhập tên",
                        minlength: "tên đăng nhập phải ít nhất 2 kí tự"
                    },
                    password:{
                        required: "Vui lòng nhập mật khẩu",
                        minlength: "mật khẩu phải ít nhất 8 kí tự",
                        pwcheck: "Mật khẩu phải có ít nhất một chữ in hoa, một kí tự số và từ 8 ký tự trở lên"
                    },
                    password_confirm:{
                        required: "Vui lòng xác nhận lại mật khẩu",
                        minlength: "mật khẩu phải ít nhất 8 kí tự",
                        equalTo: "Mật khẩu xác nhận không trùng khớp"
                    },
                    name_staff:{
                        required: "Vui lòng nhập tên nhân viên"
                    },
                    phone:{
                        required: "Vui lòng nhập số điện thoại",
                        number: "Hãy nhập đúng số điện thoại của bạn",
                        minlength: "Số điện thoại của bạn chưa hợp lệ"
                    },
                },
                errorClass: 'error',
                submitHandler: function(form) {
                    form.submit();
                }//Đây là một hàm tùy chỉnh được gọi khi biểu mẫu đã được kiểm tra hợp lệ và sẵn sàng để gửi đi.
            });
            $.validator.addMethod("pwcheck",
                function(value, element) {
                    // Kiểm tra có ít nhất một chữ in hoa
                    var hasUppercase = /[A-Z]/.test(value);
                    // Kiểm tra có ít nhất một kí tự số
                    var hasNumber = /\d/.test(value);
                    return hasUppercase && hasNumber;
                },
            );
        });
    </script>
@endsection
