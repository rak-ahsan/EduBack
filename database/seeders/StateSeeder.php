<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('states')->insert([
            ['id' => 1, 'country_id' => 1, 'name' => 'Dhaka', 'state_code' => 'DHA'],
            ['id' => 2, 'country_id' => 1, 'name' => 'Chattogram', 'state_code' => 'CHA'],
            ['id' => 3, 'country_id' => 1, 'name' => 'Rajshahi', 'state_code' => 'RAJ'],
            ['id' => 4, 'country_id' => 1, 'name' => 'Khulna', 'state_code' => 'KHU'],
            ['id' => 5, 'country_id' => 1, 'name' => 'Barishal', 'state_code' => 'BAR'],
            ['id' => 6, 'country_id' => 1, 'name' => 'Sylhet', 'state_code' => 'SYL'],
            ['id' => 7, 'country_id' => 1, 'name' => 'Rangpur', 'state_code' => 'RAN'],
            ['id' => 8, 'country_id' => 1, 'name' => 'Mymensingh', 'state_code' => 'MYM'],
       
        ]);
    }
}
