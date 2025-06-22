<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Branch;
use App\Models\ConsultantAssign;

class ConsultantAssignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consultants = User::whereIn('role_id', [8, 9])->get(); // Junior + Senior Consultants
        $branches = Branch::all();

        $assignedConsultants = [];

        foreach ($consultants as $index => $consultant) {
            if (in_array($consultant->id, $assignedConsultants)) {
                continue; // Already assigned to a branch
            }

            $branch = $branches[$index % $branches->count()];
            ConsultantAssign::create([
                'consultant_id' => $consultant->id,
                'branch_id' => $branch->id,
            ]);
            $assignedConsultants[] = $consultant->id;
        }
    }
}
