<?php

namespace App\Http\Controllers;

use App\Models\StudentTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class AppTrainingController extends Controller
{
    /**
     * Display a paginated listing of student trainings.
     */
    public function indexAppTraining(Request $request)
    {
        $leadTanning = StudentTraining::where('lead_id', $request->lead_id)->get();

        return response()->json([
            'status' => true,
            'leadTanning'   => $leadTanning
        ], 200);
    }

    /**
     * Store a newly created student training in storage.
     */
    public function storeAppTraining(Request $request)
    {
        $request->validate([
            'lead_id'      => 'required|exists:leads,id',
            'title'        => 'nullable|string',
            'topic'        => 'nullable|string',
            'institue'     => 'nullable|string',
            'passing_year' => 'nullable|integer',
            'duration'     => 'nullable|integer',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = uploadImage($request->file('image'), 'student_trainings', 'train_');
            }

            $studentTraining = StudentTraining::create([
                'lead_id'      => $request->lead_id,
                'title'        => $request->title,
                'topic'        => $request->topic,
                'institue'     => $request->institue,
                'passing_year' => $request->passing_year,
                'duration'     => $request->duration,
                'image'        => $imagePath,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Student Training created successfully.',
                'data'    => $studentTraining
            ], 200);
        } catch (Exception $e) {
            Log::error('Error creating Student Training: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error creating Student Training.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified student training in storage.
     */
    public function updateAppTraining(Request $request, $id)
    {
        $request->validate([
            'lead_id'      => 'required|exists:leads,id',
            'title'        => 'nullable|string',
            'topic'        => 'nullable|string',
            'institue'     => 'nullable|string',
            'passing_year' => 'nullable|integer',
            'duration'     => 'nullable|integer',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $studentTraining = StudentTraining::findOrFail($id);
            $imagePath = updateImage($request->file('image'), $studentTraining->image, 'student_trainings', 'train_');
            $requestData = $request->all();
            $requestData['image'] = $imagePath;
            $studentTraining->update($requestData);

            return response()->json([
                'status'  => true,
                'message' => 'Student Training updated successfully.',
                'data'    => $studentTraining
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating Student Training: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error updating Student Training.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified student training from storage.
     */
    public function destroyAppTraining($id)
    {
        try {
            $studentTraining = StudentTraining::findOrFail($id);
            $studentTraining->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Student Training deleted successfully.',
                'data'    => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting Student Training: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error deleting Student Training.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}