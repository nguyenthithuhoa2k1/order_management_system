@extends('admin.layout.master')
@section('content')
    <x-errors/>
    @foreach($dataProducts as $products)
        <form method="POST" class=" form edit-product" action="{{url('products/'.$products->id)}}">
            @csrf
            @method('PUT')
            <h1 class="title">chỉnh sửa sản phẩm</h1>
                <input class="input" type="hidden" name="version" value="{{$products->version}}">
                <div>
                    <span>Mã sản phẩm</span>
                    <input class="input" type="text" name="product_code" value="{{old('product_code',$products->product_code)}}">
                </div>
                <div>
                    <span>Tên sản phẩm</span>
                    <input class="input" type="text" name="name" value="{{old('name',$products->name)}}">
                </div>
                <div>
                    <span>Giá bán</span>
                    <input class="input" type="text" name="price_sell" value="{{old('price_sell',$products->price_sell)}}">
                </div>
                <div>
                    <span>Giá mua</span>
                    <input class="input" type="text" name="price_buy" value="{{old('price_buy',$products->price_buy)}}">
                </div>
                <div>
                    <span>Số lượng tồn kho</span>
                    <input id="quantity" class="input" type="text" name="quantity" value="{{old('quantity',$products->quantity)}}">
                </div>
            <button class="button" type="submit">Chỉnh sửa</button>
        </form>
    @endforeach
    <script>
        $(document).ready(function(){
            $('.edit-product').validate({
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
            //không thể chỉnh sửa input['quantity']
            $(document).ready(function(){
                $('.edit-product input#quantity').prop('disabled', true);
            });
        });
    </script>
@endsection
