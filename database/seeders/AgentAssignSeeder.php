<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AgentAssign;

class AgentAssignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $managers = User::where('role_id', 10)->get(); // Agent Managers
        $agents = User::where('role_id', 11)->get();    // Agents

        $assignedAgentIds = [];

        foreach ($agents as $index => $agent) {
            if (in_array($agent->id, $assignedAgentIds)) {
                continue; // Skip if already assigned
            }

            $manager = $managers[$index % $managers->count()];

            AgentAssign::create([
                'agent_manager_id' => $manager->id,
                'agent_id' => $agent->id,
            ]);

            $assignedAgentIds[] = $agent->id;
        }
    }
}
