<div class="sidebar">
    <?php
        $url = request()->route()->getName();
    ?>
    <ul>
        <li class="sidebar-home"><i class="fa-solid fa-house"></i> Home</li>
        <li class="{{($url ==='users' ? 'active' : '')}}"><a href="{{url('list/users')}}">Danh sách nhân viên</a></li>
        <li class="{{($url === 'registerUsers' ? 'active' : '')}}"><a href="{{url('register/users')}}">Thêm mới nhân viên</a></li>
        <li class="{{($url === 'products.index' ? 'active' : '')}}"><a href="{{url('/products')}}">Danh sách sản phẩm</a></li>
        <li class="{{($url === 'products.create' ? 'active' : '')}}"><a href="{{url('/products/create')}}">Thêm mới sản phẩm</a></li>
        <li class="{{($url === 'customers.index' ? 'active' : '')}}"><a href="{{url('/customers')}}">Danh sách khách hàng</a></li>
        <li class="{{($url === 'customers.create' ? 'active' : '')}}"><a href="{{url('/customers/create')}}">Thêm mới khách hàng</a></li>
        <li class="{{($url === 'orders.index' ? 'active' : '')}}"><a href="{{url('/orders')}}">Quản lí sản phẩm</a></li>
        <li class="{{($url === 'important-location' ? 'active' : '')}}"><a href="{{url('/important-location')}}">Nhập hàng & Phân bổ</a></li>
        <li class="{{($url === 'analytics' ? 'active' : '')}}"><a href="{{url('/analytics')}}">Analytics</a></li>
    </ul>
</div>
