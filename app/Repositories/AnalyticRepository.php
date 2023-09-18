<?php
    namespace App\Repositories;
    use App\Interfaces\AnalyticRepositoryInterface;
    use Illuminate\Support\Facades\DB;

    class AnalyticRepository implements AnalyticRepositoryInterface
    {
        public function getDataAnalytics($request)
        {
            $data = [];
            $dateStart = empty($request->date_start) ? '1999-01-01' : $request->date_start;
            $dateEnd = empty($request->date_end) ? '9999-12-31' : $request->date_end;
            //get data customer k mua sản phẩm nào
            $dataCustomer =  DB::table('orders')->rightJoin('customers', 'customers.id', '=', 'orders.customer_id')
                                                ->select('customers.id', 'customers.name', 'customers.address', 'customers.phone')
                                                ->whereNull('orders.id')
                                                ->whereBetween('customers.created_at',[$dateStart,$dateEnd])
                                                ->groupBy('customers.id', 'customers.name', 'customers.address', 'customers.phone')
                                                ->orderBy('customers.name', 'DESC')
                                                ->paginate(2, ['customers.id', 'customers.name', 'customers.address', 'customers.phone'], 'dataCustomer');

            //get data products được mua nhiều nhất
            $productIdBestseler =   DB::table('orders')->join('products', 'orders.product_id', '=', 'products.id')
                                                    ->select('products.id', 'products.product_code', 'products.name', 'products.quantity', DB::raw('SUM(orders.quantity) as total_quantity'))
                                                    ->where('orders.status', 2)
                                                    ->whereBetween('orders.created_at',[$dateStart,$dateEnd])
                                                    ->groupBy('orders.product_id', 'products.id', 'products.product_code', 'products.name', 'products.quantity')
                                                    ->orderBy('total_quantity', 'DESC')
                                                    ->paginate(2, ['orders.product_id', 'products.id', 'products.product_code', 'products.name', 'products.quantity'], 'productBestseller');
            //get data products không ai mua
            $dataProduct = DB::table('products')->leftJoin('orders', 'products.id', '=', 'orders.product_id')
                                                ->select('products.id', 'products.name', 'products.product_code')
                                                ->whereNull('orders.id')
                                                ->whereBetween('products.created_at', [ $dateStart, $dateEnd ])
                                                ->groupBy('orders.product_id','products.id', 'products.name', 'products.product_code')
                                                ->orderBy('products.product_code')
                                                ->paginate(2, ['orders.id', 'products.id', 'products.name', 'products.product_code'], 'dataProduct');
             $data['dataCustomer'] = $dataCustomer;
             $data['productIdBestseller'] = $productIdBestseler;
             $data['dataProduct'] = $dataProduct;
            return $data;

        }
        public function fetchDataCustomer($request) {
            //get data customer k mua sản phẩm nào
            $page = $request->input('page', 1);
            $dateStart = empty($request->date_start) ? '1999-01-01' : $request->date_start;
            $dateEnd = empty($request->date_end) ? '9999-12-31' : $request->date_end;

            $dataCustomer =  DB::table('orders')->rightJoin('customers', 'customers.id', '=', 'orders.customer_id')
                                                    ->select('customers.id', 'customers.name', 'customers.address', 'customers.phone')
                                                    ->whereNull('orders.id')
                                                    ->whereBetween('customers.created_at',[$dateStart,$dateEnd])
                                                    ->groupBy('customers.id', 'customers.name', 'customers.address', 'customers.phone')
                                                    ->orderBy('customers.name', 'DESC')
                                                    ->paginate(2, ['customers.id', 'customers.name', 'customers.address', 'customers.phone'], 'page', $page);
            return $dataCustomer;
        }

        public function fetchDataProductIdBestSeller($request) {
            //get data products được mua nhiều nhất
            $page = $request->input('page', 1);

            $dateStart = empty($request->date_start) ? '1900/01/01' : $request->date_start;
            $dateEnd = empty($request->date_end) ? '9999/12/31' : $request->date_end;

            $productIdBestseler =   DB::table('orders')->join('products', 'orders.product_id', '=', 'products.id')
                                                    ->select('products.id', 'products.product_code', 'products.name', 'products.quantity', DB::raw('SUM(orders.quantity) as total_quantity'))
                                                    ->where('orders.status', 2)
                                                    ->whereBetween('orders.created_at',[$dateStart,$dateEnd])
                                                    ->groupBy('orders.product_id', 'products.id', 'products.product_code', 'products.name', 'products.quantity')
                                                    ->orderBy('total_quantity', 'DESC')
                                                    ->paginate(2, ['orders.product_id', 'products.id', 'products.product_code', 'products.name', 'products.quantity'], 'page', $page);
            return $productIdBestseler;
        }

        public function fetchDataProduct($request) {
            //get data products không ai mua
            $page = $request->input('page', 1);

            $dateStart = empty($request->date_start) ? '1900/01/01' : $request->date_start;
            $dateEnd = empty($request->date_end) ? '9999/12/31' : $request->date_end;

            $dataProduct = DB::table('products')->leftJoin('orders', 'products.id', '=', 'orders.product_id')
                                                ->select('products.id', 'products.name', 'products.product_code')
                                                ->whereNull('orders.id')
                                                ->whereBetween('products.created_at', [ $dateStart, $dateEnd ])
                                                ->groupBy('orders.product_id','products.id', 'products.name', 'products.product_code')
                                                ->orderBy('products.product_code')
                                                ->paginate(2, ['orders.id', 'products.id', 'products.name', 'products.product_code'], 'page', $page);
            return $dataProduct;
        }
    }
