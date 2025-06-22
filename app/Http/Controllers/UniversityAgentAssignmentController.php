<?php

namespace App\Http\Controllers;

use App\Models\UniversityAgentAssignment;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use App\Models\University;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UniversityAgentAssignmentController extends Controller
{
    /**
     * Display a paginated listing of university-agent assignments.
     */
    public function indexUAAssignment(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $universities = University::all();
        $users = User::all();

        $assignments = UniversityAgentAssignment::when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                })->orWhereHas('university', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                });
            })
            ->with('user:id,name', 'university:id,uni_name')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status'      => true,
            'data'        => $assignments,
            'universities'=> $universities,
            'users'       => $users,
        ], 200);
    }

    /**
     * Store a newly created university-agent assignment.
     */
    public function storeUAAssignment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'university_id' => 'required|exists:users,id',
        ]);

        try {
            $assignment = UniversityAgentAssignment::create([
                'user_id' => $request->user_id,
                'university_id' => $request->university_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Assignment created successfully.',
                'data' => $assignment,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error creating assignment: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error creating assignment.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Remove the specified university-agent assignment.
     */
    public function destroyUAAssignment($id)
    {
        try {
            $assignment = UniversityAgentAssignment::findOrFail($id);
            $assignment->delete();

            return response()->json([
                'status' => true,
                'message' => 'Assignment deleted successfully.',
                'data' => null,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting assignment: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error deleting assignment.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
