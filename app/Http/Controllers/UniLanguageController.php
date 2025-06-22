<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\UniLanguage;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class UniLanguageController extends Controller
{
    /**
     * Display a paginated listing of UniLanguages.
     */
    public function indexUniLanguage(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $language = Language::when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', "%$search%")
                             ->orWhere('country_code', 'LIKE', "%$search%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $language
        ], 200);
    }


    /**
     * Store a newly created UniLanguage.
     */
    public function storeUniLanguage(Request $request)
    {
        $request->validate([
            'university_id' => 'required|integer',
            'language_id' => 'required|integer',
            'overall_score' => 'nullable|string',
            'reading' => 'nullable|string',
            'writing' => 'nullable|string',
            'speaking' => 'nullable|string',
            'listening' => 'nullable|string',
            // 'status' => 'nullable|in:active,inactive',
        ]);

        try {
            $uniLanguage = UniLanguage::create($request->only([
                'university_id',
                'language_id',
                'overall_score',
                'reading',
                'writing',
                'speaking',
                'listening',
                'status',
            ]));

            return response()->json([
                'status'  => true,
                'message' => 'UniLanguage created successfully.',
                'data'    => $uniLanguage
            ], 200);
        } catch (Exception $e) {
            Log::error('Error creating UniLanguage: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error creating UniLanguage.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified UniLanguage.
     */
    public function updateUniLanguage(Request $request, $id)
    {
        $request->validate([
            'university_id' => 'required|integer',
            'language_id' => 'required|integer',
            'overall_score' => 'nullable|string',
            'reading' => 'nullable|string',
            'writing' => 'nullable|string',
            'speaking' => 'nullable|string',
            'listening' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $uniLanguage = UniLanguage::findOrFail($id);

            $uniLanguage->update($request->only([
                'university_id',
                'language_id',
                'overall_score',
                'reading',
                'writing',
                'speaking',
                'listening',
                'status',
            ]));

            return response()->json([
                'status'  => true,
                'message' => 'UniLanguage updated successfully.',
                'data'    => $uniLanguage
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating UniLanguage: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error updating UniLanguage.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified UniLanguage.
     */
    public function destroyUniLanguage($id)
    {
        try {
            $uniLanguage = UniLanguage::findOrFail($id);
            $uniLanguage->delete();

            return response()->json([
                'status'  => true,
                'message' => 'UniLanguage deleted successfully.',
                'data'    => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting UniLanguage: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error deleting UniLanguage.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
