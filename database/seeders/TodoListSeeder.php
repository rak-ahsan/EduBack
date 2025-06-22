<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Faker\Factory as Faker;

class TodoListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            // Ensure that user_assignotor_id and user_executor_id are different
            do {
                $userAssignator = User::inRandomOrder()->first();
                $userExecutor = User::inRandomOrder()->first();
            } while ($userAssignator->id === $userExecutor->id); // Ensure the users are different

            TodoList::create([
                'user_assignotor_id' => $userAssignator->id,
                'user_executor_id' => $userExecutor->id,
                'task_duration' => $faker->date,
                'task_description' => $faker->sentence(10),
            ]);
        }
    }
}
