<?php

namespace App\Http\Controllers;

use App\Models\UniCampus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class UniCampusController extends Controller
{
    /**
     * Display a paginated listing of campuses.
     */
    public function indexUniCampus(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $campuses = UniCampus::when($search, function ($query, $search) {
            return $query->where('campus_name', 'LIKE', "%$search%");
        })
        ->with('university:id,uni_name')
        ->orderBy('id', 'desc')
        ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $campuses,
        ], 200);
    }

    /**
     * Store a newly created campus in storage.
     */
    public function storeUniCampus(Request $request)
    {
        $request->validate([
            'university_id' => 'required|exists:universities,id',
            'state_id'     => 'required|exists:states,id',
            'campus_name'   => 'required|string|max:255',
            // 'status'        => 'required|in:active,inactive',
        ]);

        try {
            $campus = UniCampus::create([
                'university_id' => $request->university_id,
                'campus_name'   => $request->campus_name,
                'state_id'     => $request->state_id,
                'status'        => 'active',
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Campus created successfully.',
                'data'    => $campus
            ], 200);
        } catch (Exception $e) {
            Log::error('Error creating Campus: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error creating Campus.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified campus in storage.
     */
    public function updateUniCampus(Request $request, $id)
    {
        $request->validate([
            'university_id' => 'required|exists:universities,id',
            'campus_name'   => 'required|string|max:255',
            'status'        => 'required|in:active,inactive',
        ]);

        try {
            $campus = UniCampus::findOrFail($id);
            $campus->update($request->all());

            return response()->json([
                'status'  => true,
                'message' => 'Campus updated successfully.',
                'data'    => $campus
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating Campus: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error updating Campus.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified campus from storage.
     */
    public function destroyUniCampus($id)
    {
        try {
            $campus = UniCampus::findOrFail($id);
            $campus->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Campus deleted successfully.',
                'data'    => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting Campus: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error deleting Campus.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
