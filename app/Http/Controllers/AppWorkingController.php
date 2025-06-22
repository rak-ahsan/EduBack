<?php

namespace App\Http\Controllers;

use App\Models\StudentExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class AppWorkingController extends Controller
{
    /**
     * Display a paginated listing of student experiences.
     */
    public function indexAppWorking(Request $request)
    {
        $leadWorking = StudentExperience::where('lead_id', $request->lead_id)->get();

        return response()->json([
            'status' => true,
            'leadWorking'   => $leadWorking
        ], 200);
    }

    /**
     * Store a newly created student experience in storage.
     */
    public function storeAppWorking(Request $request)
    {
        $request->validate([
            'lead_id'        => 'required|exists:leads,id',
            'company'        => 'nullable|string',
            'designation'    => 'nullable|string',
            'location'       => 'nullable|string',
            'job_start_date' => 'nullable|date',
            'job_end_date'   => 'nullable|date',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = uploadImage($request->file('image'), 'student_experiences', 'work_');
            }

            $studentExperience = StudentExperience::create([
                'lead_id'        => $request->lead_id,
                'company'        => $request->company,
                'designation'    => $request->designation,
                'location'       => $request->location,
                'job_start_date' => $request->job_start_date,
                'job_end_date'   => $request->job_end_date,
                'image'          => $imagePath,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Student Experience created successfully.',
                'data'    => $studentExperience
            ], 200);
        } catch (Exception $e) {
            Log::error('Error creating Student Experience: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error creating Student Experience.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified student experience in storage.
     */
    public function updateAppWorking(Request $request, $id)
    {
        $request->validate([
            'lead_id'        => 'required|exists:leads,id',
            'company'        => 'nullable|string',
            'designation'    => 'nullable|string',
            'location'       => 'nullable|string',
            'job_start_date' => 'nullable|date',
            'job_end_date'   => 'nullable|date',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $studentExperience = StudentExperience::findOrFail($id);
            $imagePath = updateImage($request->file('image'), $studentExperience->image, 'student_experiences', 'work_');
            $requestData = $request->all();
            $requestData['image'] = $imagePath;
            $studentExperience->update($requestData);

            return response()->json([
                'status'  => true,
                'message' => 'Student Experience updated successfully.',
                'data'    => $studentExperience
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating Student Experience: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error updating Student Experience.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified student experience from storage.
     */
    public function destroyAppWorking($id)
    {
        try {
            $studentExperience = StudentExperience::findOrFail($id);
            $studentExperience->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Student Experience deleted successfully.',
                'data'    => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting Student Experience: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error deleting Student Experience.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
