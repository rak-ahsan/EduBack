<?php

namespace App\Http\Controllers;

use App\Models\UniCampusMapping;
use Illuminate\Http\Request;
use App\Models\UniCourse;
use App\Models\UniIntakeMapping;
use App\Models\UniLanguageMapping;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UniCourseController extends Controller
{
    /**
     * Display a paginated listing of UniCourses.
     */
    public function indexUniCourse(Request $request)
    {
        $request->validate([
            'university_id' => 'required|integer|exists:universities,id',
        ]);
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $uniCourses = UniCourse::when($search, function ($query, $search) {
            return $query->where('course_name', 'LIKE', "%$search%")
                ->orWhere('status', 'LIKE', "%$search%");
        })
            ->where('university_id', $request->university_id)
            ->with(['program', 'languageMappings', 'campusMappings', 'intakeMappings', 'intakeMappings.intake:id,name', 'campusMappings.campus:id,campus_name,state_id', 'campusMappings.campus.state:id,name', 'languageMappings.language:id,short_name'])
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        $intakes = UniIntakeMapping::where('university_id', $request->university_id)->get();

        return response()->json([
            'status' => true,
            'data'   => $uniCourses,
            // 'intakes'   => $intakes

        ], 200);
    }

    /**
     * Store a newly created UniCourse.
     */
    public function storeUniCourse(Request $request)
    {

        // return $request;
        $request->validate([
            'university_id'         => 'required|integer',
            'program_id'            => 'required|integer',
            'course_name'           => 'required|string|max:255',
            'course_fees'           => 'nullable|numeric',
            'course_duration'       => 'nullable|string|max:100',
            'course_academic_req'   => 'nullable|string',
            'course_link'           => 'nullable|string',
            'status'                => 'nullable|in:active,inactive',
        ]);

        try {

            DB::beginTransaction();
            $uniCourse = UniCourse::create($request->only([
                'university_id',
                'program_id',
                'course_name',
                'course_fees',
                'course_duration',
                'course_academic_req',
                'course_link',
                'status'
            ]));

            if ($request->filled('intakes')) {
                $intakes = is_array($request->intakes) ? $request->intakes : [$request->intakes];
                foreach ($intakes as $intakeId) {
                    UniIntakeMapping::create([
                        'university_id' => $request->university_id,
                        'uni_courses_id' => $uniCourse->id,
                        'uni_intake_id' => $intakeId,
                    ]);
                }
            }

            if ($request->filled('campuses')) {
                $campuses = is_array($request->campuses) ? $request->campuses : [$request->campuses];
                foreach ($campuses as $campusesId) {
                    UniCampusMapping::create([
                        'university_id' => $request->university_id,
                        'uni_course_id' => $uniCourse->id,
                        'uni_campus_id' => $campusesId,
                    ]);
                }
            }
            if ($request->filled('englishRequirements')) {
                foreach ($request->englishRequirements as $englishRequirement) {
                    UniLanguageMapping::create([
                        'university_id' => $request->university_id,
                        'uni_courses_id' => $uniCourse->id,
                        'language_id' => $englishRequirement['language_id']['value'],
                        'overall_score' => $englishRequirement['overall_score'],
                        'reading' => $englishRequirement['reading_score'],
                        'writing' => $englishRequirement['writing_score'],
                        'speaking' => $englishRequirement['speaking_score'],
                        'listening' => $englishRequirement['listening_score'],
                        'status' => 'active',
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'UniCourse created successfully.',
                'data'    => $uniCourse
            ], 200);
        } catch (Exception $e) {
            Log::error('Error creating UniCourse: ' . $e->getMessage());
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Error creating UniCourse.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified UniCourse.
     */
    public function updateUniCourse(Request $request, $id)
    {
        $request->validate([
            'university_id'         => 'required|integer',
            'program_id'            => 'required|integer',
            'course_name'           => 'required|string|max:255',
            'course_fees'           => 'nullable|numeric',
            'course_duration'       => 'nullable|string|max:100',
            'course_academic_req'   => 'nullable|string',
            'course_link'           => 'nullable|string',
            'status'                => 'nullable|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();

            $uniCourse = UniCourse::findOrFail($id);

            $uniCourse->update($request->only([
                'university_id',
                'program_id',
                'course_name',
                'course_fees',
                'course_duration',
                'course_academic_req',
                'course_link',
                'status'
            ]));

            // Handle intakes
            if ($request->filled('intakes')) {
                UniIntakeMapping::where('uni_courses_id', $uniCourse->id)->delete();

                $intakes = is_array($request->intakes) ? $request->intakes : [$request->intakes];
                foreach ($intakes as $intakeId) {
                    UniIntakeMapping::create([
                        'university_id' => $request->university_id,
                        'uni_courses_id' => $uniCourse->id,
                        'uni_intake_id' => $intakeId,
                    ]);
                }
            }

            // Handle campuses
            if ($request->filled('campuses')) {
                // First, delete old mappings
                UniCampusMapping::where('uni_course_id', $uniCourse->id)->delete();

                $campuses = is_array($request->campuses) ? $request->campuses : [$request->campuses];
                foreach ($campuses as $campusId) {
                    UniCampusMapping::create([
                        'university_id' => $request->university_id,
                        'uni_course_id' => $uniCourse->id,
                        'uni_campus_id' => $campusId,
                    ]);
                }
            }

            // Handle english requirements
            if ($request->filled('englishRequirements')) {
                // First, delete old mappings
                UniLanguageMapping::where('uni_courses_id', $uniCourse->id)->delete();

                foreach ($request->englishRequirements as $englishRequirement) {
                    UniLanguageMapping::create([
                        'university_id' => $request->university_id,
                        'uni_courses_id' => $uniCourse->id,
                        'language_id' => $englishRequirement['language_id']['value'],
                        'overall_score' => $englishRequirement['overall_score'],
                        'reading' => $englishRequirement['reading_score'],
                        'writing' => $englishRequirement['writing_score'],
                        'speaking' => $englishRequirement['speaking_score'],
                        'listening' => $englishRequirement['listening_score'],
                        'status' => 'active',
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'UniCourse updated successfully.',
                'data' => $uniCourse
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating UniCourse: ' . $e->getMessage());
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error updating UniCourse.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified UniCourse.
     */
    public function destroyUniCourse($id)
    {
        try {
            $uniCourse = UniCourse::findOrFail($id);
            $uniCourse->delete();

            return response()->json([
                'status'  => true,
                'message' => 'UniCourse deleted successfully.',
                'data'    => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting UniCourse: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error deleting UniCourse.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
