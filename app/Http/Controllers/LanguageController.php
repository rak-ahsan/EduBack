<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Models\Language;
use Exception;
use Illuminate\Support\Facades\Log;
use Session;

class LanguageController extends Controller
{
    public function indexLanguage(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $languages = Language::when($search, function ($query, $search) {
            return $query->where('short_name', 'LIKE', "%$search%")
                         ->orWhere('full_name', 'LIKE', "%$search%");
        })->orderBy('id', 'desc')->paginate($perPage);

        return response()->json([
            'status' => true,
            'data' => $languages
        ], 200);
    }

    public function storeLanguage(Request $request)
    {
        $request->validate([
            'short_name' => 'required|string|max:50',
            'full_name' => 'required|string|max:255',
        ]);

        try {
            $language = Language::create([
                'short_name' => $request->short_name,
                'full_name' => $request->full_name
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Language created successfully.',
                'data' => $language
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error creating language: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error creating language.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateLanguage(Request $request, $id)
    {
        $request->validate([
            'short_name' => 'required|string|max:50',
            'full_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $language = Language::findOrFail($id);
            $language->update([
                'short_name' => $request->short_name,
                'full_name' => $request->full_name,
                'status' => $request->status
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Language updated successfully.',
                'data' => $language
            ], 200);

        } catch (\Exception $e) {
            Log::error('error updating language', $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error updating language.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyLanguage($id)
    {
        try {
            $language = Language::findOrFail($id);
            $language->delete();

            return response()->json([
                'status' => true,
                'message' => 'Language deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error deleting language', $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error deleting language.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



}
