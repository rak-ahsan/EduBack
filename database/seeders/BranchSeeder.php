<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('branches')->insert([
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Dhaka Branch', 'phone' => '8801723609080', 'email' => 'branch@gmail.com', 'address' => 'Mohammadpur 1207'],
            ['country_id' => 1, 'state_id' => 2, 'name' => 'Chattogram Branch', 'phone' => '8801723609080', 'email' => 'branch@gmail.com', 'address' => 'Mohammadpur 1207'],
            ['country_id' => 1, 'state_id' => 3, 'name' => 'Rajshahi Branch', 'phone' => '8801723609080', 'email' => 'branch@gmail.com', 'address' => 'Mohammadpur 1207'],
            ['country_id' => 1, 'state_id' => 4, 'name' => 'Khulna Branch', 'phone' => '8801723609080', 'email' => 'branch@gmail.com', 'address' => 'Mohammadpur 1207'],
            ['country_id' => 1, 'state_id' => 5, 'name' => 'Barishal Branch', 'phone' => '8801723609080', 'email' => 'branch@gmail.com', 'address' => 'Mohammadpur 1207'],
            ['country_id' => 1, 'state_id' => 6, 'name' => 'Sylhet Branch', 'phone' => '8801723609080', 'email' => 'branch@gmail.com', 'address' => 'Mohammadpur 1207'],
            ['country_id' => 1, 'state_id' => 7, 'name' => 'Rangpur Branch', 'phone' => '8801723609080', 'email' => 'branch@gmail.com', 'address' => 'Mohammadpur 1207'],
            ['country_id' => 1, 'state_id' => 8, 'name' => 'Mymensingh Branch', 'phone' => '8801723609080', 'email' => 'branch@gmail.com', 'address' => 'Mohammadpur 1207'],
        ]);
    }
}
