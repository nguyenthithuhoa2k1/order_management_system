@extends('admin.layout.master')
@section('content')
    <div class="form analytics">
        <form  method="get" action="{{url('analytics')}}">
            @csrf
            <div>
                <label for="">Ngày bắt đầu</label>
                <input type="date" name="date_start" value="{{ request('date_start') ?? old('date_start') }}">
            </div>
            <div>
                <label for="">Ngày kết thúc</label>
                <input type="date" name="date_end" value="{{ request('date_end') ?? old('date_end') }}">
            </div>
            <button class="button" type="submit">Ok</button>
        </form>
        <form method="get" id="paginate">
            @csrf
            <div>
                <a href="">Danh sách khách hàng không mua sản phẩm nào</a>
                <table>
                    <thead>
                        <th>STT</th>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                    </thead>
                    <tbody id="dataCustomer">
                        {{-- @if($data['dataCustomer'])
                            @foreach ($data['dataCustomer'] as $dataCustomer )
                                <tr>
                                    <td>{{$dataCustomer->id}}</td>
                                    <td>{{$dataCustomer->name}}</td>
                                    <td>{{$dataCustomer->phone}}</td>
                                    <td>{{$dataCustomer->address}}</td>
                                </tr>
                            @endforeach
                        @endif --}}
                    </tbody>
                </table>
                <div id="dataCustomer-pagination" class="pagination"></div>
                {{-- <div class="pagination" id="pagination1">
                    <input type="hidden" name="dataCustomer" id="page1" value="{{$data['dataCustomer']->currentPage()}}">
                    <button class="pagination" type="button" dataPreviousPage1="{{ $data['dataCustomer']->previousPageUrl() }}" data-name="dataCustomer" data-page="{{ $data['dataCustomer']->currentPage() - 1 }}"><<<</button>
                        @for ($i = 1; $i <= $data['dataCustomer']->lastPage(); $i++)
                            @if ($i === $data['dataCustomer']->currentPage())
                                <span class="current-page">{{ $i }}</span>
                            @else
                                <button class="pagination" type="button" data-page="{{$i}}" data-name="dataCustomer" dataPageOnClick1="{{ $i }}" data="{{ $i }}">{{ $i }}</button>
                            @endif
                        @endfor
                        <button class="pagination" type="button" data-page="{{ $data['dataCustomer']->currentPage() + 1 }}" data-name="dataCustomer" dataNextPage1="{{ $data['dataCustomer']->nextPageUrl() }}" data="{{ $data['dataCustomer']->nextPageUrl() }}">>>></button>
                </div> --}}
            </div>
            <div>
                <a href="">Danh sách sản phẩm bán chạy nhất</a>
                <table>
                    <thead>
                        <th>STT</th>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                    </thead>
                    <tbody id="productIdBestseller">
                        {{-- @if($data['productIdBestseller'])
                            @foreach ($data['productIdBestseller'] as $dataProduct )
                                <tr>
                                    <td>{{$dataProduct->id}}</td>
                                    <td>{{$dataProduct->product_code}}</td>
                                    <td>{{$dataProduct->name}}</td>
                                    <td>{{$dataProduct->total_quantity}}</td>
                                </tr>
                            @endforeach
                        @endif --}}
                    </tbody>
                </table>
                <div id="productIdBestseller-pagination" class="pagination"></div>
                {{-- <div class="pagination" id="pagination2">
                    <input type="hidden" name="productIdBestseller" id="page2" value="{{$data['productIdBestseller']->currentPage()}}">
                    <button class="pagination" type="button" dataPreviousPage2="{{ $data['productIdBestseller']->previousPageUrl() }}" data-page ="{{ $data['productIdBestseller']->currentPage() - 1 }}" data-name="productIdBestseller"  data="{{ $data['productIdBestseller']->previousPageUrl() }}"><<<</button>
                        @for ($i = 1; $i <= $data['productIdBestseller']->lastPage(); $i++)
                            @if ($i === $data['productIdBestseller']->currentPage())
                                <span class="current-page">{{ $i }}</span>
                            @else
                                <button class="pagination" type="button" data-page="{{ $i }}" data-name="productIdBestseller" dataPageOnClick2="{{ $i }}" data="{{ $i }}">{{ $i }}</button>
                            @endif
                        @endfor
                        <button class="pagination" type="button" data-page="{{ $data['productIdBestseller']->currentPage() + 1 }}" data-name="productIdBestseller" dataNextPage2="{{ $data['productIdBestseller']->nextPageUrl() }}" data="{{ $data['productIdBestseller']->nextPageUrl() }}">>>></button>
                </div> --}}
            </div>
            <div>
                <a href="">Danh sách sản phẩm không có đơn đặt hàng</a>
                <table>
                    <thead>
                        <th>STT</th>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                    </thead>
                    <tbody id="dataProduct">
                        {{-- @if($data['dataProduct'])
                            @foreach ($data['dataProduct'] as $dataProduct )
                                <tr>
                                    <td>{{$dataProduct->id}}</td>
                                    <td>{{$dataProduct->product_code}}</td>
                                    <td>{{$dataProduct->name}}</td>
                                </tr>
                            @endforeach
                        @endif --}}
                    </tbody>
                </table>
                <div id="dataProduct-pagination" class="pagination">
                </div>
                {{-- <div class="pagination" id="pagination3">
                    <input type="hidden" name="dataProduct" id="page3" value="{{$data['dataProduct']->currentPage()}}">
                        <button class="pagination" type="button" data-page="{{ $data['dataProduct']->currentPage() - 1 }}" data-name="dataProduct" dataPreviousPage3="{{ $data['dataProduct']->previousPageUrl() }}" data="{{ $data['dataProduct']->previousPageUrl() }}"><<<</button>
                        @for ($i = 1; $i <= $data['dataProduct']->lastPage(); $i++)
                            @if ($i === $data['dataProduct']->currentPage())
                                <span class="current-page">{{ $i }}</span>
                            @else
                                <button class="pagination" type="button" data-page="{{ $i }}" data-name="dataProduct" dataPageOnClick3="{{ $i }}" data="{{ $i }}">{{ $i }}</button>
                            @endif
                        @endfor
                        <button class="pagination" type="button" data-page="{{ $data['dataProduct']->currentPage() + 1 }}" data-name="dataProduct" dataNextPage3="{{ $data['dataProduct']->nextPageUrl() }}" data="{{ $data['dataProduct']->nextPageUrl() }}">>>></button>
                </div> --}}

            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            // Initial load
            loadData('dataCustomer', 1);
            loadData('productIdBestseller', 1);
            loadData('dataProduct', 1);

            function loadData(tableId, page) {
                // get condition search
                const dateStart = $('input[name="date_start"]').val();
                const dateEnd = $('input[name="date_end"]').val();

                // get url
                if (tableId == 'dataCustomer') {
                    url = "{{url('/analytics/fetch_data/dataCustomer')}}"
                } else if (tableId == 'productIdBestseller') {
                    url = "{{url('/analytics/fetch_data/productIdBestseller')}}"
                } else {
                    url = "{{url('/analytics/fetch_data/dataProduct')}}"
                }

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'page': page,
                        'date_start': dateStart,
                        'date_end': dateEnd
                    },
                    success: function (data) {
                        console.log(data)
                        const tableBodyElement = $(`#${tableId}`);
                        const paginationElement = $(`#${tableId}-pagination`);

                        tableBodyElement.empty(); // Clear previous data
                        if(data.data.data){
                            $.each(data.data.data, function (index, item) {
                                // Render data for each row
                                if (tableId == 'dataCustomer') {
                                    tableBodyElement.append(`
                                        <tr>
                                            <td>${item.id}</td>
                                            <td>${item.name}</td>
                                            <td>${item.phone}</td>
                                            <td>${item.address}</td>
                                        </tr>
                                    `);
                                } else if (tableId == 'productIdBestseller') {
                                    tableBodyElement.append(`
                                        <tr>
                                            <td>${item.id}</td>
                                            <td>${item.product_code}</td>
                                            <td>${item.name}</td>
                                            <td>${item.total_quantity}</td>
                                        </tr>
                                    `);
                                } else {
                                    tableBodyElement.append(`
                                        <tr>
                                            <td>${item.id}</td>
                                            <td>${item.product_code}</td>
                                            <td>${item.name}</td>
                                        </tr>
                                    `);
                                }
                            });
                        }else{
                            tableBodyElement.append(`<span>Không có giá trị nào phù hợp</span`);
                        }

                        // Hiển thị liên kết phân trang
                        paginationElement.empty(); // Xóa liên kết phân trang trước đó
                        // Add "<<<" link
                        if(data.data.data){
                            if (data.data.prev_page_url) {
                                const prevPageNumber = data.data.current_page - 1;
                                paginationElement.append(`<a class="page-link" href="#" data-page="${prevPageNumber}"> &lt;&lt;&lt; </a>`);
                            } else {
                                paginationElement.append(`<span> &lt;&lt;&lt; </span>`);
                            }

                            // Add page numbers
                            for (let i = 1; i <= data.data.last_page; i++) {
                                const currentPageNumber = data.data.current_page;
                                if (i === currentPageNumber) {
                                    paginationElement.append(`<span class="current-page"> ${i} </span>`);
                                } else {
                                    paginationElement.append(`<a class="page-link" href="#" data-page="${i}"> ${i} </a>`);
                                }
                            }

                            // Add ">>>" link
                            if (data.data.next_page_url) {
                                const nextPageNumber = data.data.current_page + 1;
                                paginationElement.append(`<a class="page-link" href="#" data-page="${nextPageNumber}"> &gt;&gt;&gt; </a>`);
                            } else {
                                paginationElement.append(`<span> &gt;&gt;&gt; </span>`);
                            }
                        }

                        // Bắt sự kiện click trên các nút hoặc số trang
                        paginationElement.find('a.page-link').on('click', function (e) {
                            e.preventDefault(); // Ngăn chặn mặc định sự kiện chuyển trang

                            const page = $(this).data('page');
                            loadData(tableId, page);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }



            // $(document).on('click','button.pagination',function(){
            //     let data_page = $(this).attr('data-page');
            //     let data_name = $(this).attr('data-name');
            //     $("input[name="+data_name+"]").val(data_page);
                    // $("#paginate").submit();
            // });
        });

    </script>
@endsection
