<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [

            [
                'id' => 1,
                'name' => 'Superadmin',
                'role_id' => '1',
                'email' => 'superadmin@gmail.com',
                'phone' => '01700000001',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 2,
                'name' => 'Admin',
                'role_id' => '2',
                'email' => 'admin@gmail.com',
                'phone' => '01700000002',
                'password' => Hash::make('12345678'),
            ],

            [
                'id' => 3,
                'name' => 'Authority',
                'role_id' => '3',
                'email' => 'authority@gmail.com',
                'phone' => '01700000003',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 4,
                'name' => 'Data',
                'role_id' => '4',
                'email' => 'data@gmail.com',
                'phone' => '01700000004',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 5,
                'name' => 'Finance',
                'role_id' => '5',
                'email' => 'finance@gmail.com',
                'phone' => '01700000005',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 6,
                'name' => 'Marketing 1',
                'role_id' => '6',
                'email' => 'marketing1@gmail.com',
                'phone' => '01700000006',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 7,
                'name' => 'Marketing 2',
                'role_id' => '6',
                'email' => 'marketing2@gmail.com',
                'phone' => '01700000007',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 8,
                'name' => 'Branch Manager 1',
                'role_id' => '7',
                'email' => 'branchmanager1@gmail.com',
                'phone' => '01700000008',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 9,
                'name' => 'Branch Manager 2',
                'role_id' => '7',
                'email' => 'branchmanager2@gmail.com',
                'phone' => '01700000009',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 10,
                'name' => 'Junior Consultant 1',
                'role_id' => '8',
                'email' => 'juniorconsultant1@gmail.com',
                'phone' => '01700000010',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 11,
                'name' => 'Junior Consultant 2',
                'role_id' => '8',
                'email' => 'juniorconsultant2@gmail.com',
                'phone' => '01700000011',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 12,
                'name' => 'Senior Consultant 1',
                'role_id' => '9',
                'email' => 'seniorconsultant1@gmail.com',
                'phone' => '01700000012',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 13,
                'name' => 'Senior Consultant 2',
                'role_id' => '9',
                'email' => 'seniorconsultant2@gmail.com',
                'phone' => '01700000013',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 14,
                'name' => 'Agent Manager 1',
                'role_id' => '10',
                'email' => 'agentmanager1@gmail.com',
                'phone' => '01700000014',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 15,
                'name' => 'Agent Manager 2',
                'role_id' => '10',
                'email' => 'agentmanager2@gmail.com',
                'phone' => '01700000015',
                'password' => Hash::make('12345678'),
            ],

            [
                'id' => 16,
                'name' => 'Agent 1',
                'role_id' => '11',
                'email' => 'agent1@gmail.com',
                'phone' => '01700000016',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 17,
                'name' => 'Agent 2',
                'role_id' => '11',
                'email' => 'agent2@gmail.com',
                'phone' => '01700000017',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 18,
                'name' => 'Application Manager',
                'role_id' => '12',
                'email' => 'applicationmanager@gmail.com',
                'phone' => '01700000018',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 19,
                'name' => 'Admission 1',
                'role_id' => '13',
                'email' => 'admission1@gmail.com',
                'phone' => '01700000019',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 20,
                'name' => 'Admission 2',
                'role_id' => '13',
                'email' => 'admission2@gmail.com',
                'phone' => '01700000020',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 21,
                'name' => 'Compliance 1',
                'role_id' => '14',
                'email' => 'compliance1@gmail.com',
                'phone' => '01700000021',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 22,
                'name' => 'Compliance 2',
                'role_id' => '14',
                'email' => 'compliance2@gmail.com',
                'phone' => '01700000022',
                'password' => Hash::make('12345678'),
            ],
        ];

        foreach ($users as $user) {

            $user = User::updateOrCreate(
                [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'role_id' => $user['role_id'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                    'password' => $user['password'],
                ]
            );
        }
    }
}
