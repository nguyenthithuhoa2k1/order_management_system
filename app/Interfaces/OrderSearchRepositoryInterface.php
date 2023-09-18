<?php
namespace App\Interfaces;

interface OrderSearchRepositoryInterface
{
    public function searchProductCode($request);
    public function searchProductName($request);
    public function searchCustomerName($request);
    public function searchCustomerPhone($request);
}
