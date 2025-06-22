<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UniIntake;
use Exception;
use Illuminate\Support\Facades\Log;

class UniIntakeController extends Controller
{
    /**
     * Display a paginated listing of UniIntakes.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $uniIntakes = UniIntake::when($search, function ($query, $search) {
                return $query->where('status', 'LIKE', "%$search%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $uniIntakes
        ], 200);
    }

    /**
     * Store a newly created UniIntake.
     */
    public function storeUniIntake(Request $request)
    {
        $request->validate([
            'university_id'             => 'required|integer',
            'intake_id'                 => 'required|integer',
            'intake_application_date'   => 'nullable|date',
            'intake_interview_date'     => 'nullable|date',
            'intake_payment_date'       => 'nullable|date',
            'intake_cas_coe_i_date'     => 'nullable|date',
            'status'                    => 'nullable|in:active,inactive',
        ]);

        try {
            $uniIntake = UniIntake::create($request->only([
                'university_id',
                'intake_id',
                'intake_application_date',
                'intake_interview_date',
                'intake_payment_date',
                'intake_cas_coe_i_date',
                'status'
            ]));

            return response()->json([
                'status'  => true,
                'message' => 'UniIntake created successfully.',
                'data'    => $uniIntake
            ], 200);
        } catch (Exception $e) {
            Log::error('Error creating UniIntake: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error creating UniIntake.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified UniIntake.
     */
    public function updateUniIntake(Request $request, $id)
    {
        $request->validate([
            'university_id'             => 'required|integer',
            'intake_id'                 => 'required|integer',
            'intake_application_date'   => 'nullable|date',
            'intake_interview_date'     => 'nullable|date',
            'intake_payment_date'       => 'nullable|date',
            'intake_cas_coe_i_date'     => 'nullable|date',
            'status'                    => 'required|in:active,inactive',
        ]);

        try {
            $uniIntake = UniIntake::findOrFail($id);

            $uniIntake->update($request->only([
                'university_id',
                'intake_id',
                'intake_application_date',
                'intake_interview_date',
                'intake_payment_date',
                'intake_cas_coe_i_date',
                'status'
            ]));

            return response()->json([
                'status'  => true,
                'message' => 'UniIntake updated successfully.',
                'data'    => $uniIntake
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating UniIntake: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error updating UniIntake.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified UniIntake.
     */
    public function destroyUniIntake($id)
    {
        try {
            $uniIntake = UniIntake::findOrFail($id);
            $uniIntake->delete();

            return response()->json([
                'status'  => true,
                'message' => 'UniIntake deleted successfully.',
                'data'    => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting UniIntake: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error deleting UniIntake.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
