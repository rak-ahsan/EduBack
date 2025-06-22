<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rights')->insert([
            ['id' => 1, 'name' => 'User.view', 'module' => 'User'],
            ['id' => 2, 'name' => 'User.create', 'module' => 'User'],
            ['id' => 3, 'name' => 'User.edit', 'module' => 'User'],
            ['id' => 4, 'name' => 'User.delete', 'module' => 'User'],

            ['id' => 5, 'name' => 'Role.view', 'module' => 'Role'],
            ['id' => 6, 'name' => 'Role.create', 'module' => 'Role'],
            ['id' => 7, 'name' => 'Role.edit', 'module' => 'Role'],
            ['id' => 8, 'name' => 'Role.delete', 'module' => 'Role'],

            ['id' => 9, 'name' => 'Location.view', 'module' => 'Location'],
            ['id' => 10, 'name' => 'Location.create', 'module' => 'Location'],
            ['id' => 11, 'name' => 'Location.edit', 'module' => 'Location'],
            ['id' => 12, 'name' => 'Location.delete', 'module' => 'Location'],

            ['id' => 13, 'name' => 'Academic.view', 'module' => 'Academic'],
            ['id' => 14, 'name' => 'Academic.create', 'module' => 'Academic'],
            ['id' => 15, 'name' => 'Academic.edit', 'module' => 'Academic'],
            ['id' => 16, 'name' => 'Academic.delete', 'module' => 'Academic'],

            ['id' => 17, 'name' => 'University.view', 'module' => 'University'],
            ['id' => 18, 'name' => 'University.create', 'module' => 'University'],
            ['id' => 19, 'name' => 'University.edit', 'module' => 'University'],
            ['id' => 20, 'name' => 'University.delete', 'module' => 'University'],

            ['id' => 21, 'name' => 'AdvanceFilter.view', 'module' => 'AdvanceFilter'],
            ['id' => 22, 'name' => 'AdvanceFilter.create', 'module' => 'AdvanceFilter'],
            ['id' => 23, 'name' => 'AdvanceFilter.edit', 'module' => 'AdvanceFilter'],
            ['id' => 24, 'name' => 'AdvanceFilter.delete', 'module' => 'AdvanceFilter'],

            ['id' => 25, 'name' => 'ToDoList.view', 'module' => 'ToDoList'],
            ['id' => 26, 'name' => 'ToDoList.create', 'module' => 'ToDoList'],
            ['id' => 27, 'name' => 'ToDoList.edit', 'module' => 'ToDoList'],
            ['id' => 28, 'name' => 'ToDoList.delete', 'module' => 'ToDoList'],

            ['id' => 29, 'name' => 'Lead.view', 'module' => 'Lead'],
            ['id' => 30, 'name' => 'Lead.create', 'module' => 'Lead'],
            ['id' => 31, 'name' => 'Lead.edit', 'module' => 'Lead'],
            ['id' => 32, 'name' => 'Lead.delete', 'module' => 'Lead'],

            ['id' => 33, 'name' => 'Status.view', 'module' => 'Status'],
            ['id' => 34, 'name' => 'Status.create', 'module' => 'Status'],
            ['id' => 35, 'name' => 'Status.edit', 'module' => 'Status'],
            ['id' => 36, 'name' => 'Status.delete', 'module' => 'Status'],

            ['id' => 37, 'name' => 'Report.view', 'module' => 'Report'],
            ['id' => 38, 'name' => 'Report.create', 'module' => 'Report'],
            ['id' => 39, 'name' => 'Report.edit', 'module' => 'Report'],
            ['id' => 40, 'name' => 'Report.delete', 'module' => 'Report'],

            ['id' => 41, 'name' => 'bulkUpload.view', 'module' => 'bulkUpload'],
            ['id' => 42, 'name' => 'bulkUpload.create', 'module' => 'bulkUpload'],
            ['id' => 43, 'name' => 'bulkUpload.edit', 'module' => 'bulkUpload'],
            ['id' => 44, 'name' => 'bulkUpload.delete', 'module' => 'bulkUpload'],

            ['id' => 45, 'name' => 'singleUpload.view', 'module' => 'singleUpload'],
            ['id' => 46, 'name' => 'singleUpload.create', 'module' => 'singleUpload'],
            ['id' => 47, 'name' => 'singleUpload.edit', 'module' => 'singleUpload'],
            ['id' => 48, 'name' => 'singleUpload.delete', 'module' => 'singleUpload'],

            ['id' => 49, 'name' => 'Password.view', 'module' => 'Password'],
            ['id' => 50, 'name' => 'Password.create', 'module' => 'Password'],
            ['id' => 51, 'name' => 'Password.edit', 'module' => 'Password'],
            ['id' => 52, 'name' => 'Password.delete', 'module' => 'Password'],
        ]);
    }

}
