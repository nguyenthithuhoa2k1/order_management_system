<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAllDataUsers();
    public function seachUsers($request);
    public function save(array $data);
    public function edit($userId);
    public function update(array $data, $userId);
    public function delete($userId);
}
