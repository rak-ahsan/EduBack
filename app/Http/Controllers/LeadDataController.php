<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Lead;
use App\Models\Program;
use App\Models\StudentAcademic;
use App\Models\StudentExperience;
use App\Models\StudentLanguage;
use App\Models\StudentTraining;
use App\Models\UniCampusMapping;
use App\Models\UniIntake;
use App\Models\UniIntakeMapping;
use App\Models\University;
use App\Models\UniversityAgentAssignment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadDataController extends Controller
{
    public function leadDocumentData(Request $request, $id)
    {
        $leadPersonalDoc = Lead::where('id', $id)
            ->select('user_image', 'nid_image', 'passport_image')
            ->first();

        $leadAcademicDoc = StudentAcademic::with('program')->where('lead_id', $id)
            ->select('certificate_image', 'transcript_image', 'program_id')
            ->get();

        $programmes = Program::select('id', 'short_name')->get();
        $languages = Language::select('id', 'short_name')->get();
        $StudentExperience = StudentExperience::where('lead_id', $id)->get();
        $studentTrainings = StudentTraining::where('lead_id', $id)->get();
        $StudentLanguage = StudentLanguage::where('lead_id', $id)->with('language')->get();
        $StudentAcademic = StudentAcademic::where('lead_id', $id)->with('program')->get();

        return response()->json([
            'leadPersonalDoc' => $leadPersonalDoc,
            'leadAcademicDoc' => $leadAcademicDoc,
            'programmes' => $programmes,
            'languages' => $languages,
            'StudentExperience' => $StudentExperience,
            'StudentLanguage' => $StudentLanguage,
            'studentTrainings' => $studentTrainings,
            'StudentAcademic' => $StudentAcademic,
        ]);
    }

    public function updateLeadDocument(Request $request, $id)
    {
        $request->validate([
            'updateFor' => 'required',
            'passport_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'nid_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'user_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->updateFor === 'lead_personal') {
            $lead = Lead::findOrFail($id);

            if ($request->hasFile('passport_image')) {
                $lead->passport_image = updateImage(
                    $request->file('passport_image'),
                    $lead->passport_image,
                    'passport_documents',
                    'passport_'
                );
            }

            if ($request->hasFile('nid_image')) {
                $lead->nid_image = updateImage(
                    $request->file('nid_image'),
                    $lead->nid_image,
                    'nid_images',
                    'nid_'
                );
            }

            if ($request->hasFile('user_image')) {
                $lead->user_image = updateImage(
                    $request->file('user_image'),
                    $lead->user_image,
                    'user_images',
                    'user_'
                );
            }

            $lead->save();

            return response()->json([
                'status' => true,
                'message' => 'Personal documents updated successfully.',
                'data' => $lead,
            ]);
        }

        if ($request->updateFor === 'academic') {
            $aca = StudentAcademic::firstOrCreate(
                ['lead_id' => $id, 'program_id' => $request->program_id]
            );

            if ($request->hasFile('certificate_image')) {
                $aca->certificate_image = uploadImage($request->file('certificate_image'), 'student_academics', 'cert_');
            }

            if ($request->hasFile('transcript_image')) {
                $aca->transcript_image = uploadImage($request->file('transcript_image'), 'student_academics', 'trans_');
            }

            $aca->save();

            return response()->json([
                'status' => true,
                'message' => 'Academic documents updated successfully.',
                'data' => $aca,
            ]);
        }

        if ($request->updateFor === 'language') {
            $studentLanguage = StudentLanguage::firstOrCreate(
                ['lead_id' => $id, 'language_id' => $request->language_id]
            );

            if ($request->hasFile('image')) {
                $studentLanguage->image = updateImage($request->file('image'), $studentLanguage->image, 'student_languages', 'lang_');
            }

            $studentLanguage->save();

            return response()->json([
                'status' => true,
                'message' => 'Language document updated successfully.',
                'data' => $studentLanguage,
            ]);
        }

        if ($request->updateFor === 'training') {
            $studentLanguage = new StudentTraining();
            $studentLanguage->lead_id = $id;

            if ($request->hasFile('image')) {
                $studentLanguage->image = updateImage(
                    $request->file('image'),
                    null,
                    'student_languages',
                    'lang_'
                );
            }

            $studentLanguage->save();

            return response()->json([
                'status' => true,
                'message' => 'Training document uploaded successfully.',
                'data' => $studentLanguage,
            ]);
        }
        if ($request->updateFor === 'working') {
            $document = new StudentExperience();
            $document->lead_id = $id;
            $document->company = $request->company;
            if ($request->hasFile('image')) {
                $document->image = uploadImage($request->file('image'), 'student_experiences', 'work_');
            }
            $document->save();
            return response()->json(['status' => true, 'message' => 'Working document saved']);
        }
        return response()->json([
            'status' => false,
            'message' => 'Invalid update type.',
        ], 400);
    }

    // public function getCountryWiseUniversity($id)
    // {
    //     // $universities = University::where('country_id', $id)->get();
    //     $universities = University::with('campuses', 'languages', 'intakes', 'intakes.intake:id,name', 'campuses.state:id,name', 'languages.language:id,short_name', 'programs', 'programs.program:id,short_name')->where('country_id', $id)->get();

    //     return response()->json([
    //         'status' => true,
    //         'data'   => $universities
    //     ], 200);
    // }

    public function getCountryWiseUniversity($id)
    {
        $universitiesQuery = University::with(
            'campuses',
            'languages',
            'intakes',
            'intakes.intake:id,name',
            'campuses.state:id,name',
            'languages.language:id,short_name',
            'programs',
            'UniversityAgents.user:name,id',
            'programs.program:id,short_name'
        )->where('country_id', $id);

        if (Auth::user()->role_id == 11) {
            $assignedUniversityIds = UniversityAgentAssignment::where('user_id', Auth::user()->id)
                ->pluck('university_id')
                ->toArray();

            if (!empty($assignedUniversityIds)) {
                $universitiesQuery->whereIn('id', $assignedUniversityIds);
            }
        }

        $universities = $universitiesQuery->get();


        $users = User::where('role_id', 13)->get();
        return response()->json([
            'status' => true,
            'data'   => $universities,
            'agents'   => $users,
        ], 200);
    }


    public function getUniversityWiseData($id)
    {
        $universities = University::with(
            'campuses:id,university_id,campus_name as name',
            'uniCourses',
            'languages',
            'intakes',
            'intakes.intake:id,name',
            'campuses.state:id,name',
            'languages.language:id,short_name',
            'programs',
            'UniversityAgents.user:name,id',
            'programs.program:id,short_name'
        )->findOrFail($id);
        return response()->json([
            'status' => true,
            'data'   => $universities
        ], 200);
    }

    public function getUniversityCourse(Request $request, $id)
    {
        $request->validate([
            'university_id' => 'required|integer|exists:universities,id',
        ]);
        $intakes = UniIntakeMapping::with('intake')
            ->where('university_id', $request->university_id)
            ->where('uni_courses_id', $id)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->intake->id,
                    'name' => $item->intake->name,
                ];
            });

        $campuses = UniCampusMapping::with('campus')
            ->where('university_id', $request->university_id)
            ->where('uni_course_id', $id)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->campus->id,
                    'name' => $item->campus->campus_name,
                    'state_id' => $item->campus->state_id,
                ];
            });

        return response()->json([
            'status' => true,
            'data' => [
                'intakes' => $intakes,
                'campus' => $campuses,
            ],
        ]);
    }
}
