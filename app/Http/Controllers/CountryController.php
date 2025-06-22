<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CountryController extends Controller
{
    /**
     * Display a paginated listing of countries.
     */
    public function indexCountry(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $countries = Country::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%")
                ->orWhere('country_code', 'LIKE', "%$search%");
        })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $countries
        ], 200);
    }

    /**
     * Store a newly created country in storage.
     */
    public function storeCountry(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'country_code' => 'nullable|string|max:10',
            'phone_code'   => 'nullable|string|max:10',
        ]);

        try {
            // Create country with default status 'active'
            $country = Country::create([
                'name'         => $request->name,
                'country_code' => $request->country_code,
                'phone_code'   => $request->phone_code,
                'status'       => 'active'
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Country created successfully.',
                'data'    => $country
            ], 200);
        } catch (Exception $e) {
            Log::error('Error creating Country: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error creating Country.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified country in storage.
     */

    public function getCountryList(Request $request)
    {
        $country = Country::all();
        return response()->json([
            'status'  => true,
            'message' => 'Country updated successfully.',
            'data'    => $country
        ], 200);
    }
    public function updateCountry(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'country_code' => 'nullable|string|max:10',
            'phone_code'   => 'nullable|string|max:10',
            'status'       => 'required|in:active,inactive',
        ]);

        try {
            $country = Country::findOrFail($id);

            $country->update([
                'name'         => $request->name,
                'country_code' => $request->country_code,
                'phone_code'   => $request->phone_code,
                'status'       => $request->status
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Country updated successfully.',
                'data'    => $country
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating Country: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error updating Country.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified country from storage.
     */
    public function destroyCountry($id)
    {
        try {
            $country = Country::findOrFail($id);
            $country->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Country deleted successfully.',
                'data'    => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting Country: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error deleting Country.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
