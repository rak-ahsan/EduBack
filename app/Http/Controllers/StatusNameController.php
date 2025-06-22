<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\StatusGroup;
use App\Models\StatusName;

class StatusNameController extends Controller
{
    /**
     * Display a paginated listing of status names.
     */
    public function indexStatusName(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);
        $statusGroups = StatusGroup::select("id","name")->get();

        $statusNames = StatusName::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%")
                         ->orWhere('desc', 'LIKE', "%$search%");
        })->with('statusGroup:id,name')
          ->orderBy('id', 'desc')
          ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data' => $statusNames,
            'statusGroups' => $statusGroups
        ], 200);
    }

    public function getStatusName()
    {
        try {
            // Fetch all status names with their group info
            $statusNames = StatusName::with('statusGroup:id,name')->get();

            // Group by status group name
            $grouped = $statusNames->groupBy(function ($item) {
                return $item->statusGroup->name ?? 'Unknown';
            });

            return response()->json([
                'status' => true,
                'data' => $grouped
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error fetching status name: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Status name not found.',
                'error' => $e->getMessage()
            ], 404);
        }
    }




    /**
     * Store a newly created status name in storage.
     */
    public function storeStatusName(Request $request)
    {
        $request->validate([
            'status_group_id' => 'required|exists:status_groups,id',
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
        ]);

        try {
            $statusName = StatusName::create([
                'status_group_id' => $request->status_group_id,
                'name' => $request->name,
                'desc' => $request->desc,
                'status' => 'active', // default
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Status name created successfully.',
                'data' => $statusName
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error creating status name: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error creating status name.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified status name in storage.
     */
    public function updateStatusName(Request $request, $id)
    {
        $request->validate([
            'status_group_id' => 'required|exists:status_groups,id',
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $statusName = StatusName::findOrFail($id);
            $statusName->update([
                'status_group_id' => $request->status_group_id,
                'name' => $request->name,
                'desc' => $request->desc,
                'status' => $request->status
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Status name updated successfully.',
                'data' => $statusName
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error updating status name: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error updating status name.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified status name from storage.
     */
    public function destroyStatusName($id)
    {
        try {
            $statusName = StatusName::findOrFail($id);
            $statusName->delete();

            return response()->json([
                'status' => true,
                'message' => 'Status name deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error deleting status name: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error deleting status name.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

