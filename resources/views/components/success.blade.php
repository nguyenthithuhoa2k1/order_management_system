@if(session('success'))
    <div class="success">
        <h3 class="close"><i class="fa-solid fa-xmark"></i></h3>
        <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
        <p id="success">{{session('success')}}</p>
    </div>
@endif
