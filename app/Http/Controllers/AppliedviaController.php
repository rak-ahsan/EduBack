<?php

namespace App\Http\Controllers;

use App\Models\AppliedVia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AppliedviaController extends Controller
{
    /**
     * Display a paginated list of applied vias with optional search.
     */
    public function indexAppliedvia(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $appliedVias = AppliedVia::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
        })->orderBy('id', 'desc')->paginate($perPage);

        return response()->json([
            'status' => true,
            'data' => $appliedVias
        ], 200);
    }

    /**
     * Store a new applied via.
     */
    public function storeAppliedvia(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $appliedVia = AppliedVia::create([
                'name' => $request->name,
                'status' => 'active'
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Applied Via created successfully.',
                'data' => $appliedVia
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error creating applied via: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error creating applied via.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing applied via.
     */
    public function updateAppliedvia(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $appliedVia = AppliedVia::findOrFail($id);
            $appliedVia->update([
                'name' => $request->name,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Applied Via updated successfully.',
                'data' => $appliedVia
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error updating applied via: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error updating applied via.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete an applied via.
     */
    public function destroyAppliedvia($id)
    {
        try {
            $appliedVia = AppliedVia::findOrFail($id);
            $appliedVia->delete();

            return response()->json([
                'status' => true,
                'message' => 'Applied Via deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error deleting applied via: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error deleting applied via.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
