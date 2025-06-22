<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\AppliedVia;
use App\Models\Country;
use App\Models\Intake;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Program;
use App\Models\StatusName;
use App\Models\StudentTraining;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class LeadController extends Controller
{
    public function indexLead(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $leads = Lead::when($search, function ($query, $search) {
            return $query->where('first_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('number', 'LIKE', "%$search%");
        })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $leads
        ], 200);
    }

    public function indexLeadAdmission(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $leads = Application::when($search, function ($query, $search) {
            return $query->where('first_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('number', 'LIKE', "%$search%");
        })
            ->with(['lead:id,first_name,last_name,phone','compliance:id,name', 'university:id,uni_name', 'country:id,name', 'campus:id,campus_name', 'program:id,full_name', 'intake:id,name', 'course:id,course_name'])
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $leads
        ], 200);
    }

    public function admissionAdditionalData()
    {

        $countries = Country::all();
        $programs = Program::all();
        $intakes = Intake::all();
        $status = StatusName::where('status_group_id', 2)->get();
        $complacence_users = User::where('role_id', 14)->get();
        $applied_Via	 = AppliedVia::all();

        return response()->json([
            'status' => true,
            'countries' => $countries,
            'programs' => $programs,
            'intakes' => $intakes,
            'complacence_users' => $complacence_users,
            'applied_Via' => $applied_Via,
            'status' => $status
        ]);
    }

    public function storeLead(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            $lead = Lead::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->number,
                'email' => $request->email,
                'status' => $request->status ?? 'active',
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Lead created successfully.',
                'data' => $lead
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating lead: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error creating lead.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateLead(Request $request, $id)
    {
        try {
            $lead = Lead::findOrFail($id);
            $data = $request->all();

            if ($request->hasFile('passport_image')) {
                $data['passport_image'] = updateImage($request->file('passport_image'), $lead->passport_image, 'leads', 'passport_');
            }

            if ($request->hasFile('user_image')) {
                $data['user_image'] = updateImage($request->file('user_image'), $lead->user_image, 'leads', 'user_');
            }

            if ($request->hasFile('nid_image')) {
                $data['nid_image'] = updateImage($request->file('nid_image'), $lead->nid_image, 'leads', 'nid_');
            }

            $lead->update($data);


            $lead->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'phone'     => $request->number,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Lead updated successfully.',
                'data'    => $lead
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating lead: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error updating lead.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }



    public function destroyLead($id)
    {
        try {
            $lead = Lead::findOrFail($id);
            $lead->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Lead deleted successfully.',
                'data'    => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting lead: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error deleting lead.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function assignLeadToUser(Request $request)
    {
        try {
            $request->validate([
                'leadId' => 'required|array',
                'leadId.*' => 'integer|exists:leads,id',
                'role_id' => 'required|integer',
                'user_id' => 'required|integer|exists:users,id'
            ]);

            $columnToUpdate = $request->role_id == 8 ? 'junior_consultant_id' : 'abc_user_id';

            Lead::whereIn('id', $request->leadId)->update([
                $columnToUpdate => $request->user_id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Leads assigned successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to assign leads.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function leadAdditionalData()
    {
        $countries = Country::all();
        $programs = Program::all();
        $intakes = Intake::all();
        $status = StatusName::where('status_group_id', 1)->get();
        $complacence_users = User::whereIn('role_id', [7, 9])->get();

        return response()->json([
            'status' => true,
            'countries' => $countries,
            'programs' => $programs,
            'intakes' => $intakes,
            'complacence_users' => $complacence_users,
            'status' => $status
        ]);
    }

    public function getLeadSingleData($id)
    {
        try {
            $lead = Lead::with(['country', 'state', 'city'])->findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Lead personal info retrieved successfully.',
                'data' => $lead,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateLeads(Request $request)
    {
        $lead = Lead::findOrFail($request->lead_id);
        $lead->{$request->key} = $request->value;

        if ($request->key == "last_call_status") {
            $lead->last_call_date = Carbon::now()->toDateString();
            $lead->number_of_call = ($lead->number_of_call ?? 0) + 1;
        }

        $lead->save();

        return response()->json(['status' => true, 'message' => 'Lead updated successfully.']);
    }

    public function updateLeadPersonalInfo(Request $request, $id)
    {
        $validated = $request->validate([
            'country_id' => 'sometimes|integer|exists:countries,id',
            'state_id' => 'sometimes|integer|exists:states,id',
            'city_id' => 'sometimes|integer|exists:cities,id',
            'address' => 'sometimes|string|max:255',
            'first_name' => 'sometimes|string|max:100',
            'last_name' => 'sometimes|string|max:100',
            'birthday' => 'sometimes|date',
            'email' => 'sometimes|email|max:255',
            'phone' => 'sometimes|string|max:20',
            'alt_phone' => 'sometimes|string|max:20',
            'fathers_name' => 'sometimes|string|max:100',
            'mothers_name' => 'sometimes|string|max:100',
            'gender' => 'sometimes|string|max:50',
            'blood_group' => 'sometimes|string|max:10',
            'marital_status' => 'sometimes|string|max:50',
            'religion' => 'sometimes|string|max:50',
            'nationality' => 'sometimes|string|max:100',
            'nid_number' => 'sometimes|string|max:100',
            'nid_image' => 'sometimes|file|mimes:jpeg,jpg,png,pdf|max:2048',
            'user_image' => 'sometimes|file|mimes:jpeg,jpg,png|max:2048',
        ]);

        $lead = Lead::findOrFail($id);
        $exclude = ['lead_id', 'nid_image', 'user_image'];
        foreach ($validated as $key => $value) {
            if (!in_array($key, $exclude)) {
                $lead->{$key} = $value;
            }
        }
        if ($request->hasFile('nid_image')) {
            $lead->nid_image = updateImage($request->file('nid_image'), $lead->nid_image, 'nid_images', 'nid_');
        }

        if ($request->hasFile('user_image')) {
            $lead->user_image = updateImage($request->file('user_image'), $lead->user_image, 'user_images', 'user_');
        }

        $lead->save();

        return response()->json([
            'status' => true,
            'message' => 'Lead personal info updated successfully.',
            'data' => $lead,
        ]);
    }

    public function updateLeadPassportInfo(Request $request, $id)
    {
        $validated = $request->validate([
            'passport_number'    => 'required|string|max:255',
            'issue_date'         => 'required|date',
            'expiry_date'        => 'required|date',
            'passport_document'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $lead = Lead::findOrFail($id);

        foreach ($validated as $key => $value) {
            if ($key !== 'passport_document') {
                $lead->{$key} = $value;
            }
        }

        if ($request->hasFile('passport_document')) {
            $lead->passport_image = updateImage(
                $request->file('passport_document'),
                $lead->passport_image,
                'passport_documents',
                'passport_'
            );
        }

        $lead->save();

        return response()->json([
            'status' => true,
            'message' => 'Lead passport info updated successfully.',
            'data' => $lead,
        ]);
    }

    public function updateLeadsApplicationData(Request $request,$id)
    {
        $lead = Application::findOrFail($id);
        $lead->{$request->key} = $request->value;
        $lead->save();

        return response()->json(['status' => true, 'message' => 'Lead updated successfully.']);
    }
}
