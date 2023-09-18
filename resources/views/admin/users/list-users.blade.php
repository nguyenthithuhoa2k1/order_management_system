@extends('admin.layout.master')
@section('content')
    <div class="list-users form_list">
        <form class="form-search" method="get" action="{{url('list/users')}}">
            <x-success/>
             <x-errors/>
            @csrf
            <h1>danh sách nhân viên</h1>
            <div>
                <span>Tên đăng nhập</span>
                <input type="text" name="username" value="{{request('username')}}">
            </div>
            <div>
                <span>Tên nhân viên</span>
                <input type="text" name="name_staff" value="{{request('name_staff')}}">
            </div>
            <div>
                <span>Số điện thoại</span>
                <input type="text" name="phone">
            </div>
            <div class="btn">
                <button class="button" name="btn-search" type="submit">Tìm kiếm</button>
                <button class="button btn-clear" name="btn-clear" type="button">Clear</button>
            </div>
        </form>
        <table>
            <thead>
                <th>Tên đăng nhập</th>
                <th>Tên nhân viên</th>
                <th>Số điện thoại</th>
                <th>Hành động</th>
            </thead>
            <tbody>
                @if(($dataUsers))
                    @foreach($dataUsers as $users)
                    <tr>
                        <td>{{$users->username}}</td>
                        <td>{{$users->name_staff}}</td>
                        <td>{{$users->phone}}</td>
                        <td class="action">
                            <a class="button" href="{{url('edit/users/'.$users->id)}}">Chỉnh sửa</a>
                            <form class="form-delete" method="post" action="{{url('delete/users/'.$users->id)}}">
                                @csrf
                                @method('DELETE')
                                <button class="button delete" type="submit" >Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @if($dataUsers)
        <div class="pagination">
            <a class="page-link" href="{{ $dataUsers->previousPageUrl() }}"><<<</a>
                @for ($i = 1; $i <= $dataUsers->lastPage(); $i++)
                    @if ($i === $dataUsers->currentPage())
                        <span class="current-page">{{ $i }}</span>
                    @else
                        <a class="page-link" href="{{ $dataUsers->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor
            <a class="page-link" href="{{ $dataUsers->nextPageUrl() }}">>>></a>
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
                $(this).closest('.list-users').css({
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
                    $(this).closest('.container').find('.list-users').css({
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
