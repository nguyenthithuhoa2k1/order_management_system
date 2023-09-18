<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = now()->format('Y-m-d H:i:s');
        $data = [
            'username'=> 'admin',
            'password'=> bcrypt('123456789N'),
            'password_confirm'=> bcrypt('123456789N'),
            'phone' => '12345678999',
            'name_staff'=> 'admin',
            'level'=> 0,
            'version'=> 1,
            'created_at' => $date,

        ];
        DB::table('users')->insert($data);
    }
}
