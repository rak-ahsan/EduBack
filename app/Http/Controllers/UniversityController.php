<?php

namespace App\Http\Controllers;

use App\Models\University;
use App\Models\Country;
use App\Models\Intake;
use App\Models\UniLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class UniversityController extends Controller
{
    /**
     * Display a paginated listing of universities.
     */
    public function indexUniversity(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);
        // $countries = Country::all();

        $universities = University::when($search, function ($query, $search) {
            return $query->where('uni_name', 'LIKE', "%$search%")
                         ->orWhere('ranking', 'LIKE', "%$search%");
        })
        ->with('country:id,name')
        ->orderBy('id', 'desc')
        ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $universities,
            // 'countries' => $countries,
        ], 200);
    }


    public function universityDetails(Request $request){
        $university = University::with('campuses','languages','intakes','intakes.intake:id,name','campuses.state:id,name','languages.language:id,short_name','programs','programs.program:id,short_name')->findOrFail($request->university_id);
        $intakes = Intake::select('id','name')->get();

        return response()->json([
            'status'  => true,
            'message' => 'University additional Data retrieve.',
            'university'    => $university,
            'intakes'    => $intakes,
        ], 200);
    }
    /**
     * Store a newly created university in storage.
     */
    public function storeUniversity(Request $request)
    {
        $request->validate([
            'country_id'         => 'required|exists:countries,id',
            'uni_name'           => 'required|string|max:255',
            'application_fees'   => 'required|string|max:255',
            'ranking'            => 'required|string|max:255',
            'initial_deposit'    => 'required|string|max:255',
            'usp'                => 'required|string|max:255',
            'uni_academic_req'   => 'required|string',
            'uni_link'           => 'nullable|string',
            'scholarship'        => 'nullable|string',
            'images'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = uploadImage($request->file('image'), 'universities', 'uni_');
            }

            $university = University::create([
                'country_id'       => $request->country_id,
                'uni_name'         => $request->uni_name,
                'application_fees' => $request->application_fees,
                'ranking'          => $request->ranking,
                'initial_deposit'  => $request->initial_deposit,
                'usp'              => $request->usp,
                'uni_academic_req' => $request->uni_academic_req,
                'scholarship' => $request->scholarship,
                'uni_link'         => $request->uni_link,
                'image'            => $imagePath,
                'status'           => 'active'
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'University created successfully.',
                'data'    => $university
            ], 200);
        } catch (Exception $e) {
            Log::error('Error creating University: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error creating University.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified university in storage.
     */
    public function updateUniversity(Request $request, $id)
    {

        $request->validate([
            'country_id'         => 'required|exists:countries,id',
            'uni_name'           => 'required|string|max:255',
            'application_fees'   => 'required|string|max:255',
            'ranking'            => 'required|string|max:255',
            'initial_deposit'    => 'required|string|max:255',
            'usp'                => 'required|string|max:255',
            'uni_academic_req'   => 'required|string',
            'uni_link'           => 'nullable|string',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'             => 'required|in:active,inactive',
            'scholarship'        => 'nullable|string',
        ]);

        try {
            $university = University::findOrFail($id);
            $imagePath = updateImage($request->file('image'), $university->image, 'universities', 'uni_');
            $requestData = $request->all();
            $requestData['image'] = $imagePath;
            $university->update($requestData);

            return response()->json([
                'status'  => true,
                'message' => 'University updated successfully.',
                'data'    => $university
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating University: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error updating University.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified university from storage.
     */
    public function destroyUniversity($id)
    {
        try {
            $university = University::findOrFail($id);
            $university->delete();

            return response()->json([
                'status'  => true,
                'message' => 'University deleted successfully.',
                'data'    => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting University: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error deleting University.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
