<?php

namespace App\Http\Controllers;

use App\Models\Right;
use App\Models\Role;
use App\Models\RoleRight;
use Illuminate\Http\Request;

class RoleRightController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $role = Role::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%")
                ->orWhere('country_code', 'LIKE', "%$search%");
        })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $role
        ], 200);
    }

    public function getRoles(Request $request)
    {
        try {
            $role = Role::whereIn('id', 'desc')->get();
            return response()->json([
                'status' => true,
                'data'   => $role
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Role created successfully',
        ], 201);
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
        ]);

        // Find role by ID
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found',
            ], 404);
        }

        // Update role
        $role->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Role updated successfully',
            'role' => $role,
        ], 200);
    }

    public function deleteRole($id)
    {
        try {
            // Find the role by ID
            $role = Role::find($id);

            if (!$role) {
                return response()->json([
                    'status' => false,
                    'message' => 'Role not found',
                ], 404);
            }

            // Delete the role
            $role->delete();

            return response()->json([
                'status' => true,
                'message' => 'Role deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting the role',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function indexRight(Request $request)
    {

        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $right = Right::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
            // ->orWhere('country_code', 'LIKE', "%$search%");
        })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $right
        ], 200);
    }

    public function storeRight(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:rights,name',
            'module' => 'required|string',
        ]);

        $Right = Right::create([
            'name' => $request->module . '.' . $request->name,
            'module' => $request->module,
        ]);


        return response()->json([
            'status' => true,
            'message' => 'Right created successfully',
        ], 201);
    }
    public function updateRight(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:rights,name,' . $id,
            'module' => 'required|string',

        ]);

        // Find role by ID
        $role = Right::find($id);

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Right not found',
            ], 404);
        }

        // Update role
        $role->update([
            'name' => $request->module . '.' . $request->name,
            'module' => $request->module,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Right updated successfully',
            'role' => $role,
        ], 200);
    }

    public function deleteRight($id)
    {
        try {
            // Find the role by ID
            $role = Right::find($id);

            if (!$role) {
                return response()->json([
                    'status' => false,
                    'message' => 'Right not found',
                ], 404);
            }

            // Delete the role
            $role->delete();

            return response()->json([
                'status' => true,
                'message' => 'Right deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting the Right',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function specificRoleRight(Request $request)
    {

        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $right = RoleRight::with('right', 'role')
            ->orderBy('id', 'desc')
            ->where('role_id', $request->role_id)
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $right
        ], 200);
    }

    public function indexRoleRight(Request $request)
    {
        $roleId = $request->role_id;
        $rights = Right::all()->groupBy('module');
        $selectedRights = RoleRight::where('role_id', $roleId)->pluck('right_id')->toArray();
        return response()->json([
            'rights' => $rights,
            'selected_rights' => $selectedRights
        ]);
    }

    public function updateRoleRights(Request $request)
    {
        $roleId = $request->role_id;
        $selectedRights = $request->selected_rights;

        RoleRight::where('role_id', $roleId)->delete();
        foreach ($selectedRights as $rightId) {
            RoleRight::create([
                'role_id' => $roleId,
                'right_id' => $rightId
            ]);
        }

        return response()->json(['message' => 'Permissions updated successfully!']);
    }
}
