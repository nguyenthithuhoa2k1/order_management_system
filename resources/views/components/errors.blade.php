@if($errors->any())
    <div class="errors">
        <h3 class="close"><i class="fa-solid fa-xmark"></i></h3>
        <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
