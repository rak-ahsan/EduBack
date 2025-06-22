<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;
use Exception;
use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    /**
     * Display a paginated listing of cities.
     */
    public function indexCity(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $country = Country::all();

        $cities = City::when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', "%$search%")
                             ->orWhere('zip', 'LIKE', "%$search%");
            })
            ->with('state:id,name', 'country:id,name')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $cities,
            'country' =>$country
        ], 200);
    }

    /**
     * Store a newly created city in storage.
     */
    public function storeCity(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'name'     => 'required|string|max:255',
            'zip'      => 'nullable|string|max:20',
        ]);

        try {
            $city = City::create([
                'state_id' => $request->state_id,
                'name'     => $request->name,
                'country_id' => $request->country_id,
                'zip'      => $request->zip,
                'status'   => 'active', // default value
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'City created successfully.',
                'data'    => $city
            ], 200);

        } catch (Exception $e) {
            Log::error('Error creating City: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error creating City.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified city in storage.
     */
    public function updateCity(Request $request, $id)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'name'     => 'required|string|max:255',
            'zip'      => 'nullable|string|max:20',
            'status'   => 'required|in:active,inactive',
        ]);

        try {
            $city = City::findOrFail($id);
            $city->update([
                'state_id' => $request->state_id,
                'name'     => $request->name,
                'zip'      => $request->zip,
                'country_id' => $request->country_id,
                'status'   => $request->status,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'City updated successfully.',
                'data'    => $city
            ], 200);

        } catch (Exception $e) {
            Log::error('Error updating City: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error updating City.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified city from storage.
     */
    public function destroyCity($id)
    {
        try {
            $city = City::findOrFail($id);
            $city->delete();

            return response()->json([
                'status'  => true,
                'message' => 'City deleted successfully.',
                'data'    => null
            ], 200);

        } catch (Exception $e) {
            Log::error('Error deleting City: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error deleting City.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


}


