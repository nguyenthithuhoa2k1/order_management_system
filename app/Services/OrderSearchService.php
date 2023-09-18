<?php
namespace App\Services;

use App\Interfaces\OrderSearchRepositoryInterface;
Class OrderSearchService
{
    protected $orderSearchRepository;
    public function __construct(OrderSearchRepositoryInterface $orderSearchRepository)
    {
        $this->orderSearchRepository = $orderSearchRepository;
    }

    public function searchProductCode($request)
    {
        if(!empty($request->product_code)){
            $result = $this->orderSearchRepository->searchProductCode($request);
            return $result;
        }
    }

    public function searchProductName($request)
    {
        if(!empty($request->product_name)){
            $result = $this->orderSearchRepository->searchProductName($request);
            return $result;
        }
    }
    public function searchCustomerName($request)
    {
        if(!empty($request->customer_name)){
            $result = $this->orderSearchRepository->searchCustomerName($request);
            return $result;
        }
    }
    public function searchCustomerPhone($request)
    {
        if(!empty($request->phone)){
            $result = $this->orderSearchRepository->searchCustomerPhone($request);
            return $result;
        }
    }
}
