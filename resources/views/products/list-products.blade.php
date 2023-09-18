@extends('admin.layout.master')
@section('content')
    <div class="form_list">
        <form class="form-search" method="get" action="{{url('products')}}">
            <x-success/>
            <x-errors/>
            @csrf
            <h1>danh sách sản phẩm</h1>
            <div>
                <span>Mã sản phẩm</span>
                <input type="text" name="product_code" value="{{request('product_code')}}">
            </div>
            <div>
                <span>Tên sản phẩm</span>
                <input type="text" name="name" value="{{request('name')}}">
            </div>
            <div class="btn">
                <button class="button" name="btn-search" type="submit">Tìm kiếm</button>
                <button class="button btn-clear" name="btn-clear" type="button">Clear</button>
            </div>
        </form>
        <table>
            <thead>
                <th>Mã sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Giá bán</th>
                @if(Auth::user()->level == 0)
                    <th>Giá mua</th>
                @endif
                <th>Số lượng tồn kho</th>
                @if(Auth::user()->level == 0)
                    <th>Hành động</th>
                @endif
            </thead>
            <tbody>
                @if(isset($dataProducts))
                    @foreach($dataProducts as $products)
                    <tr>
                        <td >{{$products->product_code}}</td>
                        <td>{{$products->name}}</td>
                        <td style="width: 150px;">{{number_format($products->price_sell) . ' VNĐ'}}</td>
                        @if(Auth::user()->level == 0)
                            <td style="width: 150px;">{{number_format($products->price_buy) . ' VNĐ'}}</td>
                        @endif
                        <td>{{$products->quantity}}</td>
                        @if(Auth::user()->level == 0)
                            <td class="action" style="width: 200px;">
                                <a class="button" href="{{url('products/'.$products->id."/edit")}}">Chỉnh sửa</a>
                                <form class="form-delete" method="post" action="{{url('products/'.$products->id)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button delete" type="submit" >Xóa</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                @else
                @endif
            </tbody>
        </table>
        @if($dataProducts)
        <div class="pagination">
            <a class="page-link" href="{{ $dataProducts->previousPageUrl() }}"><<<</a>
                @for ($i = 1; $i <= $dataProducts->lastPage(); $i++)
                    @if ($i === $dataProducts->currentPage())
                        <span class="current-page">{{ $i }}</span>
                    @else
                        <a class="page-link" href="{{ $dataProducts->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor
            <a class="page-link" href="{{ $dataProducts->nextPageUrl() }}">>>></a>
        </div>
    @endif
    </div>
    <div class="form-alert hide">
        <p>Bạn có chắc muốn xóa không ?</p>
        <button class="button" type="button" value="OK">OK</button>
        <button class="button" type="button" value="Cancel">Cancel</button>
    </div>
    <script>
        $(document).ready(function(){
            $('.delete').click(function(e){
                e.preventDefault();
                $(this).closest('.form_list').css({
                    'background': 'inherit',
                    'filter': 'blur(3px)',
                    'z-index': -1
                });
                $(this).closest('.container').find('.form-alert').removeClass('hide');
                $('.form-search input[type="text"]').prop('disabled', true);
            })
            $(document).on('click', '.form-alert .button', function() {
                let btn = $(this).val();
                if (btn == "Cancel") {
                    $(this).closest('.container').find('.form-alert').addClass('hide');
                    $(this).closest('.container').find('.form_list').css({
                        'background': '',
                        'filter': '',
                        'z-index': ''
                    });
                    $('.form-search input[type="text"]').prop('disabled', false);
                } else {
                    $('.form-delete').submit();
                }
            });
            $('.btn-clear').click(function(){
                $(this).closest('.form-search').find('input').val('');
            });
        });
    </script>
@endsection
