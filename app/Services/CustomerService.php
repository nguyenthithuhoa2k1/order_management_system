<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\CustomerRepositoryInterface;

Class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * get all data  customers.
     */
    public function getAllCustomers()
    {
        $dataCustomers = $this->customerRepository->getAllCustomers();
        return $dataCustomers;
    }

    /**
     * insert  customers.
     */
    public function saveCustomer($request){
        DB::beginTransaction();
        try {
            $today = now()->format('Y-m-d H:i:s');
            $user_id = Auth::id();
            $data= [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'staff_id' => $user_id,
                'version'=>1,
                'created_at'=> $today,
            ];
            $result = $this->customerRepository->save($data);

            if ($result) {
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        }catch(\Throwable $e){
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }

    /**
     * get data to edit customers.
     */
    public function getDataCustomer($customerId)
    {
        return $this->customerRepository->getCustomerById($customerId);
    }

    /**
     * update  customers.
     */
    public function updateCustomer($request,$customerId)
    {
        DB::beginTransaction();
        try {
            $today = now()->format('Y-m-d H:i:s');
            $customer = DB::table('customers')->where('id',$customerId)->first();

            $user_id = Auth::id();
            if($customer){
                $currentVersion = $customer->version;
                if ($request->phone !== $customer->phone) {
                    $phone = $request->phone;
                    $existingCustomer =  DB::table('customers')->where('phone', $request->phone)->first();
                    if ($existingCustomer) {
                        return 'phone_duplicate';
                    }
                }
                if($currentVersion == $request->version){
                    $data = [
                        'name' => $request->name,
                        'address' => $request->address,
                        'phone' => $phone,
                        'staff_id' => $user_id,
                        'version'=> $currentVersion + 1,
                        'updated_at'=>$today,
                    ];
                    $result = $this->customerRepository->update($data,$customerId);
                    if($result){
                        DB::commit();
                        return true;
                    }else{
                        DB::rollBack();
                        return false;
                    }
                }else {
                    DB::rollBack();
                    return 'version_mismatch';
                }
            }
            DB::rollBack();
            return 'customer_not_found';

        }catch(\Throwable $e){
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }

    /**
     * delete  customers.
     */
    public function deleteCustomer($customerId)
    {
        DB::beginTransaction();
        try {
            $result = $this->customerRepository->delete($customerId);
            if($result){
                DB::commit();
                return true;
            }else{
                DB::rollBack();
                return false;
            }
        }catch(\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }

    /**
     * search  customers.
     */
    public function searchCustomers($request)
    {
        $dataCustomers = $this->customerRepository->searchCustomers($request);
        return $dataCustomers;
    }
}
