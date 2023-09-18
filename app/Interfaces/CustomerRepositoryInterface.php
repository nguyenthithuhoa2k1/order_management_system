<?php

namespace App\Interfaces;

interface CustomerRepositoryInterface
{
    public function getAllCustomers();
    public function save(array $data);
    public function update(array $data,$customerId);
    public function delete($customerId);
    public function getCustomerById($customerId);
    public function searchCustomers($request);
}
