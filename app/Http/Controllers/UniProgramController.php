<?php

namespace App\Http\Controllers;

use App\Models\UniProgram;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UniProgramController extends Controller
{
    /**
     * Display a paginated listing of UniPrograms.
     */
    public function indexUniProgram(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $uniPrograms = UniProgram::when($search, function ($query, $search) {
                return $query->where('university_id', 'LIKE', "%$search%")
                             ->orWhere('program_id', 'LIKE', "%$search%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $uniPrograms
        ], 200);
    }

    /**
     * Store a newly created UniProgram.
     */
    public function storeUniProgram(Request $request)
    {
        $request->validate([
            'university_id' => 'required|integer',
            'program_id' => [
                'required',
                'integer',
                Rule::unique('uni_programs')->where(function ($query) use ($request) {
                    return $query->where('university_id', $request->university_id);
                }),
            ],
            'status' => 'nullable|in:active,inactive',
        ], [
            'program_id.unique' => 'The program ID has already been assigned to this university. Please choose a different program.',
        ]);


        try {
            $uniProgram = UniProgram::create($request->only([
                'university_id',
                'program_id',
                'status',
            ]));

            return response()->json([
                'status'  => true,
                'message' => 'UniProgram created successfully.',
                'data'    => $uniProgram
            ], 200);
        } catch (Exception $e) {
            Log::error('Error creating UniProgram: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error creating UniProgram.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified UniProgram.
     */
    public function updateUniProgram(Request $request, $id)
    {
        $request->validate([
            'university_id' => 'required|integer',
            'program_id' => 'required|integer',
            'status' => 'nullable|in:active,inactive',
        ]);

        try {
            $uniProgram = UniProgram::findOrFail($id);

            $uniProgram->update($request->only([
                'university_id',
                'program_id',
                'status',
            ]));

            return response()->json([
                'status'  => true,
                'message' => 'UniProgram updated successfully.',
                'data'    => $uniProgram
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating UniProgram: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error updating UniProgram.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified UniProgram.
     */
    public function destroyUniProgram($id)
    {
        try {
            $uniProgram = UniProgram::findOrFail($id);
            $uniProgram->delete();

            return response()->json([
                'status'  => true,
                'message' => 'UniProgram deleted successfully.',
                'data'    => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting UniProgram: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error deleting UniProgram.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
