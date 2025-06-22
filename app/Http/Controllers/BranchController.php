<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchAssign;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class BranchController extends Controller
{
    /**
     * Display a paginated listing of branches.
     */
    public function indexBranch(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $country = Country::all();

        $branches = Branch::when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', "%$search%")
                             ->orWhere('phone', 'LIKE', "%$search%")
                             ->orWhere('email', 'LIKE', "%$search%");
            })
            ->with('state:id,name', 'country:id,name')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data' => $branches,
            'country' => $country
        ], 200);
    }

    /**
     * Store a newly created branch in storage.
     */
    public function storeBranch(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
        ]);

        try {
            $branch = Branch::create([
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'status' => 'active',
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Branch created successfully.',
                'data' => $branch
            ], 200);
        } catch (Exception $e) {
            Log::error('Error creating Branch: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error creating Branch.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified branch in storage.
     */
    public function updateBranch(Request $request, $id)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $branch = Branch::findOrFail($id);

            $branch->update([
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Branch updated successfully.',
                'data' => $branch
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating Branch: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error updating Branch.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroyBranch($id)
    {
        try {
            $branch = Branch::findOrFail($id);
            $branch->delete();

            return response()->json([
                'status' => true,
                'message' => 'Branch deleted successfully.',
                'data' => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting Branch: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error deleting Branch.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getBranchWithManager(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $branches = BranchAssign::when($search, function ($query, $search) {
                return $query->whereHas('branch', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%")
                      ->orWhere('phone', 'LIKE', "%$search%")
                      ->orWhere('email', 'LIKE', "%$search%");
                })->orWhereHas('branchManger', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%")
                      ->orWhere('email', 'LIKE', "%$search%");
                });
            })
            ->with(['branch:id,name,phone,email', 'branchManger:id,name,email'])
            ->orderBy('id', 'desc')
            ->paginate($perPage);

            $allManagers = User::where('role_id', 7)->get();
            $freeBranches = Branch::whereDoesntHave('branchAssign')->get();
            $freeManagers = User::where('role_id', 7)->whereDoesntHave('getBranch')->get();

        return response()->json([
            'status' => true,
            'data' => $branches,
            'allManagers' => $allManagers,
            'freeBranches' => $freeBranches,
            'freeManagers' => $freeManagers,
        ], 200);
    }

    public function updateBranchManager(Request $request, $id)
    {
        $request->validate([
            'branch_manager_id' => 'required|exists:users,id',
        ]);

        try {
            $branchManager = BranchAssign::findOrFail($id);
            BranchAssign::where('branch_manager_id', $request->branch_manager_id)
                ->where('id', '!=', $id)
                ->delete();
            $branchManager->branch_manager_id = $request->branch_manager_id;
            $branchManager->save();

            return response()->json([
                'status' => true,
                'message' => 'Branch manager updated successfully.',
                'data' => $branchManager
            ], 200);

        } catch (Exception $e) {
            Log::error('Error updating Branch Manager: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error updating branch manager.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function storeNewManager(Request $request)
    {
        $request->validate([
            'branch_manager_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
        ]);
        try {
            $branch_assign = new BranchAssign();
            $branch_assign->branch_manager_id = $request->branch_manager_id;
            $branch_assign->branch_id = $request->branch_id;
            $branch_assign->save();

            return response()->json([
                'status' => true,
                'message' => 'Branch Manager assigned successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



}
