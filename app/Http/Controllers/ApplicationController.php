<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Lead;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{

    public function storeIndex(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'university_id' => 'required|exists:universities,id',
            'uni_program_id' => 'required|exists:programs,id',
            'uni_course_id' => 'required|exists:uni_courses,id',
            'uni_intake_id' => 'required|exists:intakes,id',
            'uni_campus_id' => 'required|exists:uni_campuses,id',
            'admission_id' => 'required|exists:users,id',
            'lead_id' => 'required|exists:leads,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $university = University::findOrFail($request->university_id);

        DB::beginTransaction();

        try {
            $application = Application::create([
                'country_id'        => $request->country_id,
                'university_id'     => $request->university_id,
                'uni_program_id'    => $request->uni_program_id,
                'uni_course_id'     => $request->uni_course_id,
                'uni_intake_id'     => $request->uni_intake_id,
                'uni_campus_id'     => $request->uni_campus_id,
                'admission_id'      => $request->admission_id,
                'lead_id'           => $request->lead_id,
                'lead_status_id'    => $university->application_fees > 0 ? 20 : 21,
                'application_fees_amount' => $university->application_fees,
                'application_fees_status' => $university->application_fees > 0 ? 'Pending' : 'Not Required',
            ]);

            $lead = Lead::findOrFail($request->lead_id);
            $lead->lead_status_id = 18;
            $lead->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Application created successfully.',
                'data' => $application,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to create application. ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getApplicationData($id)
    {
        $application = Application::with(['university', 'campus.state.country', 'university.country:id,name', 'intake:id,name', 'program:id,short_name', 'course'])->where('lead_id', $id)->get();

        return response()->json([
            'status' => true,
            'data' => $application,
        ], 200);
    }
}
