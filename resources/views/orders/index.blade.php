@extends('admin.layout.master')
@section('content')
<div class="orders" >
    <form id="form-search" method="get" action="{{url('orders')}}">
        @csrf
        @if(Auth::check())
            @if(Auth::user()->level == 0)
                <div>
                    <span>Tên đăng nhập</span>
                    <input class="order-input" type="text" name="username" value="{{ request()->input('username') }}">
                </div>
                <div>
                    <span>Tên nhân viên</span>
                    <input class="order-input" type="text" name="name_staff" value="{{ request()->input('name_staff') }}">
                </div>
            @endif
        @endif
        <div>
            <span>Mã sản phẩm</span>
            <input class="order-input" type="text" name="product_code" value="{{ request()->input('product_code') }}">
        </div>
        <div>
            <span>Tên sản phẩm</span>
            <input class="order-input" type="text" name="product_name" value="{{ request()->input('product_name') }}">
        </div>
        <div>
            <span>Tên khách hàng</span>
            <input class="order-input" type="text" name="customer_name" value="{{ request()->input('customer_name') }}">
        </div>
        <div>
            <span>Số điện thoại</span>
            <input class="order-input" type="text" name="phone" value="{{ request()->input('phone') }}">
        </div>
        <div>
            <span>Ngày đặt hàng bắt đầu</span>
            <input class="order-input" type="date" name="date_order" value="{{ request()->input('date_order') }}">
        </div>
        <div>
            <span>Ngày đặt hàng kết thúc</span>
            <input class="order-input" type="date" name="date_allocation" value="{{ request()->input('date_allocation') }}">
        </div>
        <div class="status">
            <span>Trạng thái</span>
            <div class="checkbox-group">
                <input id="order-placed" name="status[]" type="checkbox" value="1">
                <label for="order-placed">Đã đặt hàng</label>
                <input id="order-allocated" name="status[]" type="checkbox" value="2">
                <label for="order-allocated">Đã phân bổ</label>
            </div>
        </div>
        <div class="btn">
            <button class="button" name="btn-search" type="submit">Tìm kiếm</button>
            <button class="button btn-clear" name="btn-clear" type="button">Clear</button>
        </div>
    </form>
        <x-errors/>
        <x-success/>
        <table>
            <thead>
                <th>STT</th>
                <th>Ngày đặt hàng</th>
                <th>Mã sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Giá bán</th>
                <th>Số lượng</th>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Trạng thái</th>
                <th>Ngày phân bổ</th>
                @if(Auth::check())
                    @if(Auth::user()->level == 0)
                        <th>Tên đăng nhập</th>
                        <th>Tên nhân viên</th>
                    @endif
                @endif
            </thead>
            <tbody>
                <tr class="order_new" data-position="1">
                    <form class="form-new" method="get">
                        @csrf
                        <td><input class="input" type="text" name="order_id" value="order_new_1"></td>
                        <td style="width= 12%"><input class="input" type="date" name="date_order"></td>
                        <td><input class="input" type="text" name="product_code" value=""></td>
                        <td><input class="input" type="text" name="product_name" value=""></td>
                        <td><p name="price"></p></td>
                        <input class="input" type="hidden" name="product_id" value="">

                        <td><input class="input" type="text" name="quantity"></td>
                        <td><input class="input" type="text" name="customer_name" value=""></td>
                        <td style="width:10%;"><input class="input" type="text" name="phone" value=""></td>
                        <td><p name="address"></p></td>
                        <input class="input" type="hidden" name="customer_id" value="">
                        <td>
                            <p value="1">Đã đặt hàng</p>
                        </td>
                        <td></td>
                        @if(Auth::check())
                            @if(Auth::user()->level == 0)
                                <td><p id="username">{{Auth::user()->username}}</p></td>
                                <td><p id="name_staff">{{Auth::user()->name_staff}}</p></td>
                                <input class="input" type="hidden" name="user_id" id="user_id" value="">
                            @endif
                        @endif
                    </form>
                </tr>

                @foreach($allDataOrders as $dataOrders)

                    <tr>
                        @csrf
                        <input type="hidden" name="version" value="{{$dataOrders->version}}">
                        <td style="width:2%;"><input class="input order_id" name="order_id" type="text" value="{{$dataOrders->id}}"></td>
                        <td style="width= 12%"><input class="input date_orders" type="date" name="date_order" value="{{$dataOrders->date_order}}"></td>
                        <td><input  class="input" type="text" name="product_code" value="{{$dataOrders->product_code}}"></td>
                        <td><input class="input" type="text" name="product_name" value="{{$dataOrders->product_name}}"></td>
                        <td style="width:10%;"><p name="price">{{number_format($dataOrders->price_sell).' VNĐ'}}</p></td>
                        <input class="input" type="hidden" name="product_id"  value="{{$dataOrders->product_id}}">

                        <td><input class="input" type="text" name="quantity" value="{{$dataOrders->quantity}}"></td>
                        <td><input class="input" type="text" name="customer_name" value="{{$dataOrders->customer_name}}"></td>
                        <td style="width:10%;"><input class="input" type="text" name="phone" value="{{$dataOrders->phone}}"></td>
                        <td style="width:15%;"><p name="address">{{$dataOrders->address}}</p></td>
                        <input class="input" type="hidden" name="customer_id" value="{{$dataOrders->customer_id}}">
                        <td>
                            @if($dataOrders->status == 1)
                                <p value="1">Đã đặt hàng</p>
                            @else
                                <p value="2">Đã phân bổ</p>
                            @endif
                        </td>
                        <td style="width= 12%"><input class="input" type="date" name="date_allocation" value="{{$dataOrders->date_allocation}}"></td>
                        @if(Auth::check())
                            @if(Auth::user()->level == 0)
                                <td><input class="input" type="text" name="username" value="{{$dataOrders->username}}"></td>
                                <td><input class="input" type="text" name="name_staff" value="{{$dataOrders->name_staff}}"></td>
                                <input class="input" type="hidden" name="user_id" class="user_id" value="{{Auth::id()}}">
                            @endif
                        @endif
                    </tr>
                @endforeach
                <input type="text" id="order_id" value="">
            </tbody>
        </table>

        <div class="group-btn">
            <button id="new" class="button" name="btn-new" type="button">Thêm</button>
            <button id="reset" class="button btn-clear" name="btn-clear" type="button">Reset</button>
            <button id="insert" class="button" name="btn-insert" type="submit">Lưu</button>
        </div>
        @if($allDataOrders)
            <div class="pagination">
                <a class="page-link" href="{{ $allDataOrders->previousPageUrl() }}"><<<</a>
                    @for ($i = 1; $i <= $allDataOrders->lastPage(); $i++)
                        @if ($i === $allDataOrders->currentPage())
                            <span class="current-page">{{ $i }}</span>
                        @else
                            <a class="page-link" href="{{ $allDataOrders->url($i) }}">{{ $i }}</a>
                        @endif
                    @endfor
                <a class="page-link" href="{{ $allDataOrders->nextPageUrl() }}">>>></a>
            </div>
        @endif
</div>
<script>
    $(document).ready(function(){
        $(document).on('input','input', function() {
            let url = '';
            let tr = $(this).closest('tr');
            let current_name = $(this).attr('name');
            let product_code = tr.find('input[name="product_code"]');
            let product_name = tr.find('input[name="product_name"]');
            let product_id = tr.find('input[name="product_id"]');
            let customer_id = tr.find('input[name="customer_id"]');
            let customer_name = tr.find('input[name="customer_name"]');
            let phone = tr.find('input[name="phone"]');
            let address = tr.find('p[name="address"]');
            let price = tr.find('p[name="price"]');
            let order_id = tr.find('input[name="order_id"]');
            let date_order = tr.find('input[name="date_order"]');
            let quantity = tr.find('input[name="quantity"]');
            let version = tr.find('input[name="version"]');
            let order_new_id = $(this).closest('tr.order_new').find('input[name="order_id"]').val();
            let order_update_id = $(this).closest('tr').find('input[name="order_id"]').val();

            if(current_name == 'product_code') {
                url = "<?= url('search/code'); ?>";
            } else if(current_name == 'product_name') {
                url = "<?= url('search/name'); ?>";
            } else if(current_name == 'customer_name') {
                url = "<?= url('search/customer/name'); ?>";
            } else if(current_name == 'phone') {
                url = "<?= url('search/customer/phone'); ?>";
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
                url: url,
                method: 'GET',
                dataType: 'json',
                data: {
                    [current_name]: $(this).val(),
                },
                success: function(response) {
                    if(current_name == 'product_code') {
                        if(response.result){
                            product_name.val(response.result.name);
                            product_id.val(response.result.id);
                            price.text(response.result.price_sell + ' VNĐ');
                        }else{
                            product_name.val("");
                            product_id.val("");
                            price.text("");
                        }
                    } else if(current_name == 'product_name') {
                        if(response.result){
                            product_code.val(response.result.product_code);
                            product_id.val(response.result.id);
                            price.text(response.result.price_sell + ' VNĐ');
                        }else{
                            product_code.val("");
                            product_id.val("");
                            price.text("");
                        }
                    } else if(current_name == 'customer_name') {
                        if(response.result){
                            phone.val(response.result.phone);
                            customer_id.val(response.result.id);
                            address.text(response.result.address);
                        }else{
                            phone.val("");
                            customer_id.val("");
                            address.text("");
                        }
                    } else if(current_name == 'phone') {
                        if(response.result){
                            customer_name.val(response.result.name);
                            customer_id.val(response.result.id);
                            address.text(response.result.address);
                        }else{
                            customer_name.val("");
                            customer_id.val();
                            address.text("");
                        }
                    }
                    let productId = tr.find('input[name="product_id"]');
                    let customerId = tr.find('input[name="customer_id"]');

                    let getDataOrders = localStorage.getItem('orders');
                    if(getDataOrders) {
                        getDataOrders = JSON.parse(localStorage.getItem('orders'));
                    } else {
                        getDataOrders = {};
                    }
                    if(order_id.val() === order_new_id){
                        let order_new = {
                            order_id: order_id.val(),
                            product_id: productId.val(),
                            customer_id: customerId.val(),
                            date_order: date_order.val(),
                            quantity: quantity.val(),
                        };
                        if (!getDataOrders['order_new']) {
                            getDataOrders['order_new']={};
                        }
                        getDataOrders['order_new'][order_id.val()]= order_new;

                    } else {
                        let order_update = {
                            order_id: order_id.val(),
                            product_id: productId.val(),
                            customer_id: customerId.val(),
                            version: version.val(),
                            date_order: date_order.val(),
                            quantity: quantity.val(),
                        };
                        if (!getDataOrders['order_update']) {
                            getDataOrders['order_update']={};
                        }
                        getDataOrders['order_update'][order_id.val()]= order_update;
                    }
                    localStorage.setItem('orders', JSON.stringify(getDataOrders));
                },
            });
            let getDataOrders = localStorage.getItem('orders');
            if(getDataOrders) {
                getDataOrders = JSON.parse(localStorage.getItem('orders'));
            } else {
                getDataOrders = {};
            }
            if(parseInt(order_id.val()) === parseInt(order_update_id)) {
                let order_update = {
                    quantity: quantity.val(),
                    date_order: date_order.val(),
                    version: version.val(),
                }
                if (!getDataOrders['order_update']) {
                    getDataOrders['order_update'] = {};
                }
                getDataOrders['order_update'][order_id.val()]= order_update;
                localStorage.setItem('orders', JSON.stringify(getDataOrders));
            }
        });
        $(document).on('click', 'button#insert', function(event) {
            event.preventDefault();
            if ($('.form-new').valid()) {
                let getDataOrders = localStorage.getItem('orders');
                if(getDataOrders) {
                    getDataOrders = JSON.parse(localStorage.getItem('orders'));
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
                        url: "{{url('orders/insert')}}",
                        method: 'post',
                        dataType: 'json',
                        data: {
                            'getDataOrders': getDataOrders,
                        },
                        success: function(response) {
                            if(response.success){
                                html=`
                                <div class="success">
                                    <h3 class=" close close-ajax"><i class="fa-solid fa-xmark"></i></h3>
                                    <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
                                    <p id="ajax-success">${response.success}</p>
                                </div>
                                `;
                                $('#form-search').after(html);
                                localStorage.clear();
                            }
                            if(response.errors){
                                html=`
                                <div class="errors">
                                    <h3 class=" close close-ajax"><i class="fa-solid fa-xmark"></i></h3>
                                    <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
                                    <p id="ajax-errors">${response.errors}</p>
                                </div>
                                `;
                                $('#form-search').after(html);
                                localStorage.clear();
                            }
                        },
                    });
                } else {
                    getDataOrders = {};
                }
            }
        });
        $(document).on('click','.close-ajax',function(){
            location.reload(true);
        });
        $(document).on('click','.btn-clear',function(){
            $(this).closest('#form-search').find('input').val('');
        });
        $(document).on('click','#reset',function(){
            location.reload(true);
        });
        $(document).on('click', '#new', function(){
            order_new_last = $('.order_new').last();
            position = order_new_last.data('position') + 1;
            html = `
                <tr class="order_new" data-position="${position}">
                    <td><input class="input" type="text" name="order_id" value="order_new_${position}"></td>
                    <td style="width= 12%"><input class="input" type="date" name="date_order"></td>
                    <td><input class="input" type="text" name="product_code" value=""></td>
                    <td><input class="input" type="text" name="product_name" value=""></td>
                    <td><p name="price"></p></td>
                    <input class="input" type="hidden" name="product_id" value="">

                    <td><input class="input" type="text" name="quantity"></td>
                    <td><input class="input" type="text" name="customer_name" value=""></td>
                    <td style="width:10%;"><input class="input" type="text" name="phone" value=""></td>
                    <td><p name="address"></p></td>
                    <input class="input" type="hidden" name="customer_id" value="">
                    <td>
                        <p value="1">Đã đặt hàng</p>
                    </td>
                    <td></td>
                    @if(Auth::check())
                        @if(Auth::user()->level == 0)
                            <td><p id="username">{{Auth::user()->username}}</p></td>
                            <td><p id="name_staff">{{Auth::user()->name_staff}}</p></td>
                            <input class="input" type="hidden" name="user_id" id="user_id" value="">
                        @endif
                    @endif
                </tr>
            `;
            order_new_last.after(html);
        });
    });
</script>
@endsection
