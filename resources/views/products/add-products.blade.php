@extends('admin.layout.master')
@section('content')
    <x-errors/>
    <form method="POST" class=" form add-product" action="{{url('products')}}">
        @csrf
        <h1 class="title">thêm mới sản phẩm</h1>
        <div>
            <span>Mã sản phẩm</span>
            <input class="input" type="text" name="product_code" value="{{old('product_code')}}">
        </div>
        <div>
            <span>Tên sản phẩm</span>
            <input class="input" type="text" name="name" value="{{old('name')}}">
        </div>
        <div>
            <span>Giá bán</span>
            <input class="input" type="text" name="price_sell" value="{{old('price_sell')}}">
        </div>
        <div>
            <span>Giá mua</span>
            <input class="input" type="text" name="price_buy" value="{{old('price_buy')}}">
        </div>
        <div>
            <span>Số lượng tồn kho</span>
            <input class="input" type="text" name="quantity" value="{{old('quantity')}}">
        </div>
        <button type="submit">Thêm mới</button>
    </form>
    <script>
        $(document).ready(function(){
            $('.add-product').validate({
                rules:{
                    product_code: {
                        required: true,
                        minlength: 2,
                    },
                    name: {
                        required: true,
                        minlength: 2,
                    },
                    price_sell: {
                        required: true,
                        number: true
                    },
                    price_buy: {
                        required: true,
                        number: true
                    },
                    quantity: {
                        required: true,
                        number: true,
                    },
                },
                messages:{
                    product_code:{
                        required: "Vui lòng nhập mã sản phẩm.",
                        minlength: "Tên đăng nhập phải ít nhất 2 kí tự.",
                    },
                    name:{
                        required: "Vui lòng nhập tên sản phẩm.",
                        minlength: "mật khẩu phải ít nhất 2 kí tự.",
                    },
                    price_sell:{
                        required: "Vui lòng nhập giá bán.",
                        number: "Đây không phải số. Vui lòng nhập số."
                    },
                    price_buy:{
                        required: "Vui lòng nhập giá mua.",
                        number: "Đây không phải số. Vui lòng nhập số."
                    },
                    quantity:{
                        required: "Vui lòng nhập số lượng tồn kho.",
                        number: "Đây không phải số. Vui lòng nhập số.",
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
