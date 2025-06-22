<?php

namespace App\Http\Controllers;

use App\Models\StatusGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatusGroupController extends Controller
{
    /**
     * Display a paginated listing of status groups.
     */
    public function indexStatusGroup(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $statusGroups = StatusGroup::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%")
                         ->orWhere('desc', 'LIKE', "%$search%");
        })->orderBy('id', 'desc')->paginate($perPage);

        return response()->json([
            'status' => true,
            'data' => $statusGroups
        ], 200);
    }

    /**
     * Store a newly created status group in storage.
     */
    public function storeStatusGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
        ]);

        try {
            $statusGroup = StatusGroup::create([
                'name' => $request->name,
                'desc' => $request->desc,
                'status' => 'active' // default
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Status group created successfully.',
                'data' => $statusGroup
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error creating status group: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error creating status group.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified status group in storage.
     */
    public function updateStatusGroup(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $statusGroup = StatusGroup::findOrFail($id);
            $statusGroup->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'status' => $request->status
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Status group updated successfully.',
                'data' => $statusGroup
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error updating status group: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error updating status group.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified status group from storage.
     */
    public function destroyStatusGroup($id)
    {
        try {
            $statusGroup = StatusGroup::findOrFail($id);
            $statusGroup->delete();

            return response()->json([
                'status' => true,
                'message' => 'Status group deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error deleting status group: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error deleting status group.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
