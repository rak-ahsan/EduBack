<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Exception;
use App\Imports\LeadImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LeadUploadController extends Controller
{
    /**
     * Display a listing of leads.
     */
  public function indexLeadUpload(Request $request)
{
    $search = $request->query('search');
    $perPage = $request->query('per_page', 10);
    $duplicate = $request->query('duplicate'); 

    $leads = Lead::when($search, function ($query, $search) {
        $query->where(function ($q) use ($search) {
            $q->where('first_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%");
        });
    })
    ->where(function ($query) {
        $query->where(function ($q) {
            $q->whereNull('abc_user_id')
                ->whereNull('junior_consultant_id');
        })->orWhere(function ($q) {
            $q->where('abc_user_id', Auth::id())
                ->orWhere('junior_consultant_id', Auth::id());
        });
    })
    ->when($duplicate, function ($query) {
        $query->where('duplicate', 'yes');
    })
    ->orderBy('id', 'desc')
    ->paginate($perPage);

    return response()->json([
        'status' => true,
        'data' => $leads
    ]);
}




    public function storeLeadUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,xlsx,xls|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $path = $request->file('file')->store('uploads', 'public');

        Excel::import(new LeadImport, $request->file('file'));

        return response()->json(['message' => 'Leads uploaded successfully'], 200);
    }

    /**
     * Update the specified lead.
     */
    public function updateLeadUpload(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'     => 'required|string|max:15',
        ]);

        try {
            $lead = Lead::findOrFail($id);

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

    /**
     * Remove the specified lead.
     */
    public function destroyLeadUpload($id)
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
}
