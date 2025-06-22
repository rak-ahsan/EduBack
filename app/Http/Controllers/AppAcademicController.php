<?php

namespace App\Http\Controllers;

use App\Models\StudentAcademic;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class AppAcademicController extends Controller
{
    /**
     * GET: Fetch all academic entries for a specific lead.
     */
    public function indexAppAcademic(Request $request)
    {
        $programs = Program::all();

        $leadAcademics = StudentAcademic::with('program')
            ->where('lead_id', $request->lead_id)
            ->get();

        return response()->json([
            'status' => true,
            'leadAcademics' => $leadAcademics,
            'programs' => $programs,
        ], 200);
    }

    /**
     * POST: Store a new academic record.
     */
    public function storeAppAcademic(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'program_id' => 'required|exists:programs,id',
            'group' => 'nullable|string',
            'course' => 'nullable|string',
            'cgpa' => 'nullable|string',
            'scale' => 'nullable|string',
            'duration' => 'nullable|string',
            'passing_year' => 'nullable|date',
            'institute' => 'nullable|string',
            'course_start_date' => 'nullable|date',
            'course_end_date' => 'nullable|date',
            'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'transcript_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $certificatePath = null;
            $transcriptPath = null;

            if ($request->hasFile('certificate_image')) {
                $certificatePath = uploadImage($request->file('certificate_image'), 'student_academics', 'cert_');
            }

            if ($request->hasFile('transcript_image')) {
                $transcriptPath = uploadImage($request->file('transcript_image'), 'student_academics', 'trans_');
            }

            $studentAcademic = StudentAcademic::create([
                'lead_id' => $request->lead_id,
                'program_id' => $request->program_id,
                'group' => $request->group,
                'course' => $request->course,
                'cgpa' => $request->cgpa,
                'scale' => $request->scale,
                'duration' => $request->duration,
                'passing_year' => $request->passing_year,
                'institute' => $request->institute,
                'course_start_date' => $request->course_start_date,
                'course_end_date' => $request->course_end_date,
                'certificate_image' => $certificatePath,
                'transcript_image' => $transcriptPath,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Student Academic record created successfully.',
                'data' => $studentAcademic
            ], 200);

        } catch (Exception $e) {
            Log::error('Error creating Student Academic: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error creating Student Academic.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST: Update an existing academic record.
     */
    public function updateAppAcademic(Request $request, $id)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'program_id' => 'required|exists:programs,id',
            'group' => 'nullable|string',
            'course' => 'nullable|string',
            'cgpa' => 'nullable|string',
            'scale' => 'nullable|string',
            'duration' => 'nullable|string',
            'passing_year' => 'nullable|date',
            'institute' => 'nullable|string',
            'course_start_date' => 'nullable|date',
            'course_end_date' => 'nullable|date',
            'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'transcript_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $studentAcademic = StudentAcademic::findOrFail($id);

            $certificatePath = $studentAcademic->certificate_image;
            $transcriptPath = $studentAcademic->transcript_image;

            if ($request->hasFile('certificate_image')) {
                $certificatePath = updateImage($request->file('certificate_image'), $studentAcademic->certificate_image, 'student_academics', 'cert_');
            }

            if ($request->hasFile('transcript_image')) {
                $transcriptPath = updateImage($request->file('transcript_image'), $studentAcademic->transcript_image, 'student_academics', 'trans_');
            }

            $studentAcademic->update([
                'lead_id' => $request->lead_id,
                'program_id' => $request->program_id,
                'group' => $request->group,
                'course' => $request->course,
                'cgpa' => $request->cgpa,
                'scale' => $request->scale,
                'duration' => $request->duration,
                'passing_year' => $request->passing_year,
                'institute' => $request->institute,
                'course_start_date' => $request->course_start_date,
                'course_end_date' => $request->course_end_date,
                'certificate_image' => $certificatePath,
                'transcript_image' => $transcriptPath,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Student Academic record updated successfully.',
                'data' => $studentAcademic
            ], 200);

        } catch (Exception $e) {
            Log::error('Error updating Student Academic: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error updating Student Academic.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE: Remove a student academic entry.
     */
    public function destroyAppAcademic($id)
    {
        try {
            $studentAcademic = StudentAcademic::findOrFail($id);
            $studentAcademic->delete();

            return response()->json([
                'status' => true,
                'message' => 'Student Academic record deleted successfully.'
            ], 200);

        } catch (Exception $e) {
            Log::error('Error deleting Student Academic: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error deleting Student Academic.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
