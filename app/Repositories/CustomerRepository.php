<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * get all data customers.
     */
    public function getAllCustomers()
    {
        return DB::table('customers')->leftJoin('users', 'customers.staff_id', '=', 'users.id')
                                     ->select('customers.id','customers.name','customers.phone','customers.address','customers.staff_id','users.username as username')
                                     ->orderBy('name')->paginate(2);
    }
    /**
     * insert customers.
     */
    public function save(array $data)
    {
        return DB::table('customers')->insert($data);
    }

    /**
     * update customers.
     */
    public function update(array $data,$customerId)
    {
         return DB::table('customers')->where('id',$customerId)->update($data);
    }

    /**
     * delete customers.
     */
    public function delete($customerId)
    {
        return  DB::table('customers')->where('id',$customerId)->delete();
    }

    /**
     * get data customers by id.
     */
    public function getCustomerById($customerId)
    {
        return DB::table('customers')->where('id',$customerId)->get();
    }

    /**
     * search customers.
     */
    public function searchCustomers($request)
    {
        return DB::table('customers')->join('users','customers.staff_id', '=', 'users.id')
                                    ->select('customers.id','customers.name','customers.phone','customers.address','customers.staff_id','users.username as username')
                                    ->where('customers.name',$request->name)
                                    ->orwhere('customers.phone',$request->phone)
                                    ->get();
}
}
