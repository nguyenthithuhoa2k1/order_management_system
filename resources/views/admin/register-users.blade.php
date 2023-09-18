@extends('admin.layout.master')
@section('content')
<x-errors/>
    <form method="POST" class="register form" action="{{url('register/users')}}">
        @csrf
        <h1 class="title">thêm mới nhân viên</h1>
        <div>
            <span>Tên đăng nhập (*)</span>
            <input class="input" type="text" name="username" value="{{old('username')}}">
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
            <input class="input" type="text" name="name_staff" value="{{old('name_staff')}}">
        </div>
        <div>
            <span>Số điện thoại (*)</span>
            <input class="input" type="text" name="phone" value="{{old('phone')}}">
        </div>
        <button type="submit">Thêm mới</button>
    </form>
    <script>
        $(document).ready(function(){
            $('.register').validate({
                rules:{
                    username: {
                        required: true,
                        minlength: 2,
                        checkUsername: true
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        checkPassword: true
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
                        minlength: "Tên đăng nhập phải ít nhất 2 kí tự",
                        checkUsername: "tên đăng nhập không được có khoảng trắng."
                    },
                    password:{
                        required: "Vui lòng nhập mật khẩu",
                        minlength: "mật khẩu phải ít nhất 8 kí tự",
                        checkPassword: "Mật khẩu phải có ít nhất một chữ in hoa, một kí tự số và từ 8 ký tự trở lên"
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
            // jquery regex
            $.validator.addMethod("checkPassword",
                function(value, element) {
                    // Kiểm tra có ít nhất một chữ in hoa
                    var hasUppercase = /[A-Z]/.test(value);
                    // Kiểm tra có ít nhất một kí tự số
                    var hasNumber = /\d/.test(value);
                    return hasUppercase && hasNumber;
                },
            );
            $.validator.addMethod("checkUsername",
                function(value, element) {
                    // Kiểm tra có chứa khoảng trắng không.
                    var containsWhitespace = /\s/.test(value);
                    return !containsWhitespace;
                },
            );
        });
    </script>
@endsection
