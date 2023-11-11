<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [

                'username' => 'admin',
                'name' => 'admin',
                'password' => Hash::make('pcn@2022'),
                'role' => 'admin',
                'area_id' => 1,
                'confirmpassword' => 'pcn@2022',


            ],

            [

                'email' => 'superuser',
                'name' => 'superuser',
                'password' => Hash::make('12341234'),
                'role' => 'user',
                'area_id' => 2,
                'confirmpassword' => '12341234',

            ]

        ]);
    }
}
