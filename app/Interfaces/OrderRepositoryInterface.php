<?php
namespace App\Interfaces;
interface OrderRepositoryInterface
{
    public function allDataOrders();
    public function saveOrder(array $data);
    public function updateOrder($data,$orderId);
}
