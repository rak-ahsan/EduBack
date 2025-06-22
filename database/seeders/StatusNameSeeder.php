<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status_names')->insert([
            ['id' => 1, 'status_group_id' => 1, 'name' => 'No Answer', 'desc' => ''],
            ['id' => 2, 'status_group_id' => 1, 'name' => 'Busy', 'desc' => ''],
            ['id' => 3, 'status_group_id' => 1, 'name' => 'Switched Off', 'desc' => ''],
            ['id' => 4, 'status_group_id' => 1, 'name' => 'Call Again', 'desc' => ''],
            ['id' => 5, 'status_group_id' => 1, 'name' => 'Wrong Number', 'desc' => ''],
            ['id' => 6, 'status_group_id' => 1, 'name' => 'Not Interested', 'desc' => ''],
            ['id' => 7, 'status_group_id' => 1, 'name' => 'Not Eligible', 'desc' => ''],
            ['id' => 8, 'status_group_id' => 1, 'name' => 'Other Country', 'desc' => ''],
            ['id' => 9, 'status_group_id' => 1, 'name' => 'Working with other Agent', 'desc' => ''],
            ['id' => 10, 'status_group_id' => 1, 'name' => 'Interested For Job Visa', 'desc' => ''],
            ['id' => 11, 'status_group_id' => 1, 'name' => 'Decision Pending', 'desc' => ''],
            ['id' => 12, 'status_group_id' => 1, 'name' => 'Follow UP', 'desc' => ''],
            ['id' => 13, 'status_group_id' => 1, 'name' => 'Will Visit', 'desc' => ''],
            ['id' => 14, 'status_group_id' => 1, 'name' => 'Visited', 'desc' => ''],
            ['id' => 15, 'status_group_id' => 1, 'name' => 'Will provide Document', 'desc' => ''],
            ['id' => 16, 'status_group_id' => 1, 'name' => 'Stuck', 'desc' => ''],
            ['id' => 17, 'status_group_id' => 1, 'name' => 'Waiting For English Test', 'desc' => ''],
            ['id' => 18, 'status_group_id' => 1, 'name' => 'Apply', 'desc' => ''],
            ['id' => 19, 'status_group_id' => 1, 'name' => 'Document Submitted', 'desc' => ''],

            // Status Group 2: Application Progress
            ['id' => 20, 'status_group_id' => 2, 'name' => 'Pending', 'desc' => ''],
            ['id' => 21, 'status_group_id' => 2, 'name' => 'Ready to Apply', 'desc' => ''],
            ['id' => 22, 'status_group_id' => 2, 'name' => 'Waiting for Document', 'desc' => ''],
            ['id' => 23, 'status_group_id' => 2, 'name' => 'Submitted to the Portal', 'desc' => ''],
            ['id' => 24, 'status_group_id' => 2, 'name' => 'Submitted to the University / Applied', 'desc' => ''],
            ['id' => 25, 'status_group_id' => 2, 'name' => 'Conditional Offer Letter', 'desc' => ''],
            ['id' => 26, 'status_group_id' => 2, 'name' => 'Unconditional Offer Letter', 'desc' => ''],
            ['id' => 27, 'status_group_id' => 2, 'name' => 'Rejected', 'desc' => ''],
            ['id' => 28, 'status_group_id' => 2, 'name' => 'Canceled', 'desc' => ''],

            // Status Group 3: Post-Application
            ['id' => 29, 'status_group_id' => 3, 'name' => 'Mock Interview Running', 'desc' => ''],
            ['id' => 30, 'status_group_id' => 3, 'name' => 'CAS Interview Booked', 'desc' => ''],
            ['id' => 31, 'status_group_id' => 3, 'name' => 'Waiting for CAS Interview Result', 'desc' => ''],
            ['id' => 32, 'status_group_id' => 3, 'name' => 'CAS Interview Failed', 'desc' => ''],
            ['id' => 33, 'status_group_id' => 3, 'name' => 'Tuition Fees Required', 'desc' => ''],
            ['id' => 34, 'status_group_id' => 3, 'name' => 'Tuition Fees Payment Done', 'desc' => ''],
            ['id' => 35, 'status_group_id' => 3, 'name' => 'Tuition Fees Refund Requested', 'desc' => ''],
            ['id' => 36, 'status_group_id' => 3, 'name' => 'Tuition Fees Refund', 'desc' => ''],
            ['id' => 37, 'status_group_id' => 3, 'name' => 'CAS/COE/ I20 Requested', 'desc' => ''],
            ['id' => 38, 'status_group_id' => 3, 'name' => 'CAS/COE/ I20 Received', 'desc' => ''],
            ['id' => 39, 'status_group_id' => 3, 'name' => 'Collecting Document', 'desc' => ''],
            ['id' => 40, 'status_group_id' => 3, 'name' => 'Biometrics Booked', 'desc' => ''],
            ['id' => 41, 'status_group_id' => 3, 'name' => 'VISA Applied', 'desc' => ''],
            ['id' => 42, 'status_group_id' => 3, 'name' => 'VISA Rejected', 'desc' => ''],
            ['id' => 43, 'status_group_id' => 3, 'name' => 'VISA Approved', 'desc' => ''],
            ['id' => 44, 'status_group_id' => 3, 'name' => 'Visa Interview', 'desc' => ''],
            ['id' => 45, 'status_group_id' => 3, 'name' => 'Enrolled', 'desc' => ''],
            ['id' => 46, 'status_group_id' => 3, 'name' => 'Did Not Enroll', 'desc' => ''],
            ['id' => 47, 'status_group_id' => 3, 'name' => 'Class Attended', 'desc' => ''],
            ['id' => 48, 'status_group_id' => 3, 'name' => 'Class Not Attended', 'desc' => ''],
        ]);
    }
}
