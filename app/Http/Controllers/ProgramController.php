<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Models\Program;
use Exception;
use Illuminate\Support\Facades\Log;
use Session;

class ProgramController extends Controller
{
    public function indexProgram(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $programs = Program::when($search, function ($query, $search) {
            return $query->where('short_name', 'LIKE', "%$search%")
                         ->orWhere('full_name', 'LIKE', "%$search%");
        })->orderBy('id', 'desc')->paginate($perPage);

        return response()->json([
            'status' => true,
            'data' => $programs
        ], 200);
    }

    public function storeProgram(Request $request)
    {
        $request->validate([
            'short_name' => 'required|string|max:50',
            'full_name' => 'required|string|max:255',
        ]);

        try {
            $program = Program::create([
                'short_name' => $request->short_name,
                'full_name' => $request->full_name
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Program created successfully.',
                'data' => $program
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error creating Program: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error creating Program.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProgram(Request $request, $id)
    {
        $request->validate([
            'short_name' => 'required|string|max:50',
            'full_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $program = Program::findOrFail($id);
            $program->update([
                'short_name' => $request->short_name,
                'full_name' => $request->full_name,
                'status' => $request->status
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Program updated successfully.',
                'data' => $program
            ], 200);

        } catch (\Exception $e) {
            Log::error('error updating Program',$e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error updating Program.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyProgram($id)
    {
        try {
            $program = Program::findOrFail($id);
            $program->delete();

            return response()->json([
                'status' => true,
                'message' => 'Program deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error deleting Program', $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error deleting Program.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
