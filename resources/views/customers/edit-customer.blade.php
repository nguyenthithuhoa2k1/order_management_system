@extends('admin.layout.master')
@section('content')
    <x-errors/>
    @foreach($dataCustomers as $customers)
    <form method="POST" class=" form eidt-customers" action="{{url('customers/'.$customers->id)}}">
        @csrf
        @method('PUT')
        <h1 class="title">chỉnh sửa khách hàng</h1>
        <input class="input" type="hidden" name="version" value="{{$customers->version}}">
        <div>
            <span>Tên khách hàng</span>
            <input class="input" type="text" name="name" value="{{old('name',$customers->name)}}">
        </div>
        <div>
            <span>Số điện thoại</span>
            <input class="input" type="text" name="phone" value="{{old('phone',$customers->phone)}}">
        </div>
        <div>
            <span>Địa chỉ</span>
            <input class="input" type="text" name="address" value="{{old('address',$customers->address)}}">
        </div>
        <button type="submit">Chỉnh sửa</button>
    </form>
    @endforeach
    <script>
        $(document).ready(function(){
            $('.eidt-customers').validate({
                rules:{
                    name: {
                        required: true,
                        minlength: 2,
                    },
                    phone: {
                        required: true,
                        number: true,
                        minlength: 11
                    },
                    address: {
                        required: true,
                        minlength: 10,
                    },
                },
                messages:{
                    name:{
                        required: "Vui lòng nhập tên khách hàng.",
                        minlength: "Tên khách hàng phải ít nhất 2 kí tự.",
                    },
                    phone:{
                        required: "Vui lòng nhập số điện thoại.",
                        number: "Đây không phải số. Vui lòng nhập số.",
                        minlength: "Số điện thoại phải ít nhất 11 kí tự.",
                    },
                    address:{
                        required: "Vui lòng nhập địa chỉ.",
                        minlength: "Vui lòng nhập chi tiết địa chỉ, phải ít nhất 10 kí tự.",
                    },
                },
                errorClass: 'error',
                submitHandler: function(form) {
                    form.submit();
                }//Đây là một hàm tùy chỉnh được gọi khi biểu mẫu đã được kiểm tra hợp lệ và sẵn sàng để gửi đi.
            });
        });
    </script>
@endsection
