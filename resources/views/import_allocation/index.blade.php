@extends('admin.layout.master')
@section('content')
    <div  id="important-location">
        <div style="width:75%;" class="hide messages" ><p id = "messages"></p></div>
        <form id="location-form" method="POST">
            @csrf
            <table class="important-location">
                <thead>
                    <th>STT</th>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng nhập hàng</th>
                </thead>
                <tbody>
                    @csrf
                    <tr>
                        <td></td>
                        <td><input type="text" name="product_code" id="product_code" value=""></td>
                        <td><input type="text" name="product_name" id="product_name" value=""></td>
                        <input type="hidden" name="product_id" id="product_id">
                        <td><input type="number" name="quantity"></td>
                    </tr>
                    <tr>
                        <td colspan="4"><button type="button" class="button btn-location" href="#">Phân bổ</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script>
        $(document).ready(function(){
            $("#location-form").validate({
                errorClass: 'error',
                rules: {
                    product_code: {
                        required: true
                    },
                    product_name: {
                        required: true
                    },
                    quantity: {
                        required: true,
                        min: 1
                    }
                },
                messages: {
                    product_code: {
                        required: "Không được trống"
                    },
                    product_name: {
                        required: "Không được trống"
                    },
                    quantity: {
                        required: "Không được trống",
                        min: "Số lượng phải lớn hơn hoặc bằng 1"
                    }
                }
            });
            $(document).on('input','input',function(){
                let url = "";
                let tr = $(this).closest('tr');
                let current_name = $(this).attr('name');
                let product_code = tr.find('input[name="product_code"]');
                let product_name = tr.find('input[name="product_name"]');
                let product_id = tr.find('input[name="product_id"]');
                if(current_name == 'product_code') {
                url = "<?= url('search/code'); ?>";
                } else if(current_name == 'product_name') {
                    url = "<?= url('search/name'); ?>";
                }
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    data: {
                        [current_name]: $(this).val(),
                    },
                    success: function(response) {
                        console.log(response.result);
                        if(current_name == 'product_code') {
                            if(response.result){
                                product_name.val(response.result.name);
                                product_id.val(response.result.id);
                            }else{
                                product_name.val("");
                                product_id.val("");
                            }
                        } else if(current_name == 'product_name') {
                            if(response.result){
                                product_code.val(response.result.product_code);
                                product_id.val(response.result.id);
                            }else{
                                product_code.val("");
                                product_id.val("");
                            }
                        }
                    }
                });
            });
            $(document).on('click','.button',function(){
                if ($("#location-form").valid()) {
                    var message = "";
                    let product_id = $('input[name="product_id"]').val();
                    let quantity = $('input[name="quantity"]').val();
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
                            url: "<?= url('/important-location') ?>",
                            method: 'POST',
                            dataType: 'json',
                            data: {
                                'product_id': product_id,
                                'quantity': quantity
                            },
                            success: function(response) {
                                if(response.result !=""){
                                    $.each(response.result, function(index, item) {
                                        message += item.insufficient_order_count_id;
                                        if (index < response.result.length - 1) {
                                            message += ",";
                                        }
                                    });
                                    html =`
                                            <div class="errors">
                                                <h3 class="close"><i class="fa-solid fa-xmark"></i></h3>
                                                <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
                                                <ul>
                                                    <li>Không đủ hàng phân bổ cho đơn hàng có id là: ${message}</li>
                                                </ul>
                                            </div>
                                        `;
                                    $('#messages').closest('div.messages').removeClass('hide');
                                    $('#messages').append(html);
                                    $(".btn-location").prop("disabled", true);
                                    $('.close').click(function(){
                                        location.reload();
                                        $(".btn-location").prop("disabled", false);
                                    });
                                }else{
                                    html =`
                                            <div class="success">
                                                <h3 class="close"><i class="fa-solid fa-xmark"></i></h3>
                                                <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
                                                <ul>
                                                    <p>Phân bổ thành công cho các đơn hàng.</p>
                                                </ul>
                                            </div>
                                        `;
                                    $('#messages').closest('div.messages').removeClass('hide');
                                    $('#messages').append(html);
                                    $(".btn-location").prop("disabled", true);
                                    $('.close').click(function(){
                                        location.reload();
                                        $(".btn-location").prop("disabled", false);
                                    });
                                }
                            },

                        });
                }
            });
        });
    </script>
@endsection

