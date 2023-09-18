@extends('admin.layout.master')
@section('content')
    <div class="form_list">
        <form class="form-search" method="get" action="{{url('customers')}}">
            <x-success/>
            <x-errors/>
            @csrf
            <h1>danh sách khách hàng</h1>
            <div>
                <span>Tên khách hàng</span>
                <input type="text" value="{{ request('name') }}" name="name">
            </div>
            <div>Số điện thoại</span>
                <input type="text" value="{{ request('phone') }}" name="phone">
            </div>
            <div class="btn">
                <button class="button" name="btn-search" type="submit">Tìm kiếm</button>
                <button class="button btn-clear" name="btn-clear" type="button">Clear</button>
            </div>
        </form>
        <table>
            <thead>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Nhân viên</th>
                <th>Hành động</th>
            </thead>
            <tbody>
                @if(isset($dataCustomers))
                    @foreach($dataCustomers as $customers)
                    <tr>
                        <td >{{$customers->name}}</td>
                        <td>{{$customers->phone}}</td>
                        <td>{{$customers->address}}</td>
                        <td>{{($customers->username)}}</td>
                        @if(Auth::check())
                            @if(Auth::user()->level == 0 || Auth::id() == $customers->staff_id)
                                <td class="action">
                                    <a class="button" href="{{url('customers/'.$customers->id."/edit")}}">Chỉnh sửa</a>
                                    <form class="form-delete" method="post" action="{{url('customers/'.$customers->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="button delete" type="submit" >Xóa</button>
                                    </form>
                                </td>
                            @endif
                        @endif
                    </tr>
                    @endforeach
                @else
                @endif
            </tbody>
        </table>
        @if($dataCustomers)
            <div class="pagination">
                <a class="page-link" href="{{ $dataCustomers->previousPageUrl() }}"><<<</a>
                    @for ($i = 1; $i <= $dataCustomers->lastPage(); $i++)
                        @if ($i === $dataCustomers->currentPage())
                            <span class="current-page">{{ $i }}</span>
                        @else
                            <a class="page-link" href="{{ $dataCustomers->url($i) }}">{{ $i }}</a>
                        @endif
                    @endfor
                <a class="page-link" href="{{ $dataCustomers->nextPageUrl() }}">>>></a>
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
