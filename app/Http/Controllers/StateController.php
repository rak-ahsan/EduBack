<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\State;
use Exception;
use Illuminate\Support\Facades\Log;

class StateController extends Controller
{
    /**
     * Display a paginated listing of states.
     */
    public function indexState(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);
        $country = Country::all();

        $states = State::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%")
                ->orWhere('state_code', 'LIKE', "%$search%");
        })->with('country:id,name')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $states,
            'country' => $country

        ], 200);
    }

    /**
     * Store a newly created state in storage.
     */
    public function storeState(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name'       => 'required|string|max:255',
            'state_code' => 'nullable|string|max:10',
        ]);

        try {
            $state = State::create([
                'country_id' => $request->country_id,
                'name'       => $request->name,
                'state_code' => $request->state_code,
                'status'     => 'active' // default value
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'State created successfully.',
                'data'    => $state
            ], 200);
        } catch (Exception $e) {
            Log::error('Error creating State: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error creating State.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified state in storage.
     */
    public function updateState(Request $request, $id)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name'       => 'required|string|max:255',
            'state_code' => 'nullable|string|max:10',
            'status'     => 'required|in:active,inactive',
        ]);

        try {
            $state = State::findOrFail($id);
            $state->update([
                'country_id' => $request->country_id,
                'name'       => $request->name,
                'state_code' => $request->state_code,
                'status'     => $request->status,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'State updated successfully.',
                'data'    => $state
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating State: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error updating State.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified state from storage.
     */
    public function destroyState($id)
    {
        try {
            $state = State::findOrFail($id);
            $state->delete();

            return response()->json([
                'status'  => true,
                'message' => 'State deleted successfully.',
                'data'    => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting State: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error deleting State.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function getStateByCountry(Request $request)
    {
        try {

            $states = State::where('country_id', $request->country_id)->get();
            return response()->json([
                'status' => true,
                'data'   => $states
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCityByState(Request $request)
    {
        try {

            $cities = City::where('state_id', $request->state_id)->get();
            return response()->json([
                'status' => true,
                'data'   => $cities
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
