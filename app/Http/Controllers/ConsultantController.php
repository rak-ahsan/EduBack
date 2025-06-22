<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\ConsultantAssign;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    public function getConsultant(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $Consultant = ConsultantAssign::when($search, function ($query, $search) {
                return $query->whereHas('consultant', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%")
                      ->orWhere('phone', 'LIKE', "%$search%")
                      ->orWhere('email', 'LIKE', "%$search%");
                })->orWhereHas('agent', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%")
                      ->orWhere('email', 'LIKE', "%$search%");
                });
            })
            ->with(['consultant:id,name', 'branch:id,name'])
            ->orderBy('id', 'desc')
            ->paginate($perPage);
            $Branches = Branch::orderBy('id','ASC')->get();

        return response()->json([
            'status' => true,
            'data' => $Consultant,
            // 'allManagers' => $allManagers,
            'Branches' => $Branches,
        ], 200);
    }

    public function updateConsultant(Request $request, $id)
    {
        try {
            $consultant = ConsultantAssign::findOrFail($id);
            $consultant->branch_id = $request->branch_id;
            $consultant->save();

            return response()->json([
                'status'  => true,
                'message' => 'consultant updated successfully',
            ], 200);


        }catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'error' => 'An error occurred while updating the consultant',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
