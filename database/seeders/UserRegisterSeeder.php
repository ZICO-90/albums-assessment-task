<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
   
        foreach ([1 , 2 , 3 , 4] as  $value) 
        {

            DB::table('users')->insert([
                'name' => "username{$value}",
                'email' => "username{$value}@gmail.com",
                'password' => Hash::make("username{$value}"),
            ]);
        
        }
    }
}
