<?php
 namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\UserRepositoryInterface;

 Class UserRepository implements UserRepositoryInterface
 {
    /**
     * get all data users.
     */
    public function getAllDataUsers()
    {
        return DB::table('users')->paginate(10);
    }

     /**
     *  search users.
     */
    public function seachUsers($request)
    {
        return DB::table('users')->where('username',$request->username)
                                        ->orWhere('name_staff',$request->name_staff)
                                        ->orWhere('phone',$request->phone)
                                        ->orderBy('username')->get();
    }

     /**
     * insert users.
     */
    public function save(array $data)
    {
        return DB::table('users')->insert($data);
    }

    /**
     * get data to edit users.
     */
    public function edit($userId)
    {
        return DB::table('users')->where('id',$userId)->get();
    }

    /**
     * update users.
     */
    public function update(array $data, $userId)
    {
        return DB::table('users')->where('id',$userId)->update($data);
    }

    /**
     * delete users.
     */
    public function delete($userId)
    {
        return DB::table('users')->where('id',$userId)->delete();
    }
 }
