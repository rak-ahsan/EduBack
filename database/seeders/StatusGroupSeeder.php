<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status_groups')->insert([
            ['id' => 1, 'name' => 'consultant', 'desc' => 'Student contact and Decided university Application'],
            ['id' => 2, 'name' => 'addmission', 'desc' => 'Application university & offer letter collect'],
            ['id' => 3, 'name' => 'compliance', 'desc' => 'Student interview manage and enrollment'],
       
        ]);
    }
}
