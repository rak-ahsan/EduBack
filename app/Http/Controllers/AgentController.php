<?php

namespace App\Http\Controllers;

use App\Models\AgentAssign;
use App\Models\User;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function getAgent(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $agents = AgentAssign::when($search, function ($query, $search) {
                return $query->whereHas('agentManger', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%")
                      ->orWhere('phone', 'LIKE', "%$search%")
                      ->orWhere('email', 'LIKE', "%$search%");
                })->orWhereHas('agent', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%")
                      ->orWhere('email', 'LIKE', "%$search%");
                });
            })
            ->with(['agentManger:id,name,phone,email', 'agent:id,name,email'])
            ->orderBy('id', 'desc')
            ->paginate($perPage);

            $agentManagers = User::where('role_id', 10)->get();

        return response()->json([
            'status' => true,
            'data' => $agents,
            'agentManagers' => $agentManagers,
        ], 200);
    }

    public function updateAgent(Request $request, $id)
    {
        try {
            $agent = AgentAssign::findOrFail($id);
            $agent->agent_manager_id = $request->agent_manager_id;
            $agent->save();

            return response()->json([
                'status'  => true,
                'message' => 'Agent updated successfully',
                'agent' => $agent
            ], 200);


        }catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'error' => 'An error occurred while updating the agent',
                'details' => $e->getMessage()
            ], 500);
        }
    }

}
