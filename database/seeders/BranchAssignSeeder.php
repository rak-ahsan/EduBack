<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BranchAssign;
use App\Models\Branch;

class BranchAssignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $managers = User::where('role_id', 7)->get(); // Branch Managers
        $branches = Branch::all();

        $usedBranchIds = [];
        $usedManagerIds = [];

        foreach ($managers as $manager) {
            if (in_array($manager->id, $usedManagerIds)) {
                continue; // Skip if manager already assigned
            }

            foreach ($branches as $branch) {
                if (!in_array($branch->id, $usedBranchIds)) {
                    BranchAssign::create([
                        'branch_manager_id' => $manager->id,
                        'branch_id' => $branch->id,
                    ]);
                    $usedManagerIds[] = $manager->id;
                    $usedBranchIds[] = $branch->id;
                    break;
                }
            }
        }
    }
}
