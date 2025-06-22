<?php

namespace App\Http\Controllers;

use App\Models\StudentLanguage;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class AppLanguageController extends Controller
{
    /**
     * GET: Fetch all language entries for a specific lead.
     */
    public function indexAppLanguage(Request $request)
    {
        $languages = Language::all();

        $leadLanguages = StudentLanguage::with('language')
            ->where('lead_id', $request->lead_id)
            ->get();

        return response()->json([
            'status' => true,
            'leadLanguages' => $leadLanguages,
            'languages' =>$languages
        ], 200);
    }

    /**
     * POST: Store a new language record.
     */
    public function storeAppLanguage(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'language_id' => 'required|exists:languages,id',
            'overall_result' => 'nullable|integer',
            'reading' => 'nullable|integer',
            'writing' => 'nullable|integer',
            'speaking' => 'nullable|integer',
            'listening' => 'nullable|integer',
            'examination_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = uploadImage($request->file('image'), 'student_languages', 'lang_');
            }

            $studentLanguage = StudentLanguage::create([
                'lead_id' => $request->lead_id,
                'language_id' => $request->language_id,
                'overall_result' => $request->overall_result,
                'reading' => $request->reading,
                'writing' => $request->writing,
                'speaking' => $request->speaking,
                'listening' => $request->listening,
                'examination_date' => $request->examination_date,
                'expiry_date' => $request->expiry_date,
                'image' => $imagePath,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Student Language created successfully.',
                'data' => $studentLanguage
            ], 200);

        } catch (Exception $e) {
            Log::error('Error creating Student Language: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error creating Student Language.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * PUT: Update an existing language record.
     */
    public function updateAppLanguage(Request $request, $id)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'language_id' => 'required|exists:languages,id',
            'overall_result' => 'nullable|integer',
            'reading' => 'nullable|integer',
            'writing' => 'nullable|integer',
            'speaking' => 'nullable|integer',
            'listening' => 'nullable|integer',
            'examination_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $studentLanguage = StudentLanguage::findOrFail($id);

            $imagePath = $studentLanguage->image;

            if ($request->hasFile('image')) {
                $imagePath = updateImage($request->file('image'), $studentLanguage->image, 'student_languages', 'lang_');
            }

            $studentLanguage->update([
                'lead_id' => $request->lead_id,
                'language_id' => $request->language_id,
                'overall_result' => $request->overall_result,
                'reading' => $request->reading,
                'writing' => $request->writing,
                'speaking' => $request->speaking,
                'listening' => $request->listening,
                'examination_date' => $request->examination_date,
                'expiry_date' => $request->expiry_date,
                'image' => $imagePath,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Student Language updated successfully.',
                'data' => $studentLanguage
            ], 200);

        } catch (Exception $e) {
            Log::error('Error updating Student Language: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error updating Student Language.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE: Remove a student language entry.
     */
    public function destroyAppLanguage($id)
    {
        try {
            $studentLanguage = StudentLanguage::findOrFail($id);
            $studentLanguage->delete();

            return response()->json([
                'status' => true,
                'message' => 'Student Language deleted successfully.'
            ], 200);

        } catch (Exception $e) {
            Log::error('Error deleting Student Language: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error deleting Student Language.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
