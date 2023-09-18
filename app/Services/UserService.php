<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\UserRepositoryInterface;

class UserService
{

    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

     /**
     * get all data users.
     */
    public function getAllUsers()
    {
        $dataUsers = $this->userRepository->getAllDataUsers();
        return $dataUsers;
    }

    /**
     * search users.
     */
    public function seachUsers($request)
    {
        if(empty($request)){
            $dataUsers = DB::table('users')->get();
            return $dataUsers;
        }else{
            $dataUsers =$this->userRepository->seachUsers($request);
            return $dataUsers;
        }
    }

    /**
     * insert users.
     */
    public function saveUser($request)
    {
        DB::beginTransaction();
        try {
            $today =now()->format('Y-m-d H:i:s');

            $data = [
                'username'=> $request->username,
                'password'=> bcrypt($request->password),
                'password_confirm'=> bcrypt($request->password_confirm),
                'name_staff'=> $request->name_staff,
                'phone'=> $request->phone,
                'level'=> 1,
                'created_at'=> $today,
            ];
            $result = $this->userRepository->save($data);

            if ($result) {
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return false;
        }
    }

    /**
     * get data to edit users.
     */
    public function editUser($userId)
    {
        $dataUsers = $this->userRepository->edit($userId);
        return $dataUsers;
    }

     /**
     * update users.
     */
    public function updateUser($request, $userId)
    {
        DB::beginTransaction();
        try {
            $today = now()->format('Y-m-d H:i:s');
            $dataUser = DB::table('users')->where('id',$userId)->first();
            if($dataUser){
                $currentVersion = $dataUser->version;
                if($currentVersion == $request->version){
                    $data = [
                        'username' => $request->username,
                        'password' => bcrypt($request->password),
                        'password_confirm' => bcrypt($request->password_confirm),
                        'name_staff' => $request->name_staff,
                        'phone' => $request->phone,
                        'updated_at'=> $today,
                        'version'=>$currentVersion + 1,
                    ];
                    $result = $this->userRepository->update($data,$userId);
                    if($result) {
                        DB::commit();
                        return true;
                    }else {
                        DB::rollBack();
                        return false;
                    }
                }else {
                    DB::rollBack();
                    return 'version_mismatch';
                }
            }
            DB::rollBack();
            return 'user_not_found';
        }catch(\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }

    /**
     * delete users.
     */
    public function deleteUser($userId)
    {
         DB::beginTransaction();
        try{
            $result = $this->userRepository->delete($userId);
            if($result){
                DB::commit();
                return true;
            }else {
                DB::rollBack();
                return false;
            }
        } catch(\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }
}
