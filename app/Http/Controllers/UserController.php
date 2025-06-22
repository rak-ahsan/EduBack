<?php

namespace App\Http\Controllers;

use App\Models\AgentAssign;
use App\Models\Branch;
use App\Models\BranchAssign;
use App\Models\ConsultantAssign;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a paginated listing of users.
     */
    public function indexUser(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);
        $roles = Role::where('status','active')->get();

        $branches = Branch::all();
        $agentManager = User::where('role_id', 10)->get();

        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%");
        })->with('role:id,name')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $users,
            'roles'  => $roles,
            'branches'  => $branches,
            'agentManager'  => $agentManager,
        ], 200);
    }

    /**
     * Store a newly created user in storage.
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email',
            'phone'   => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'role_id' => $request->role_id,
                'name'    => $request->name,
                'email'   => $request->email,
                'phone'   => $request->phone,
                'password'=> Hash::make($request->password),
            ]);

            if ($request->role_id == 7 && !empty($request->branch_id)) {
                $existingManager = BranchAssign::where('branch_id', $request->branch_id)->first();

                if ($existingManager) {
                    return response()->json(['message' => 'This branch already has a manager assigned. Please choose another branch.'], 400);
                } else {
                    $branch_assign = new BranchAssign();
                    $branch_assign->branch_manager_id = $user->id;
                    $branch_assign->branch_id = $request->branch_id;
                    $branch_assign->save();
                }
            }


            if(($request->role_id==9|| $request->role_id==8)&& !empty($request->branch_id)){
                $branch_assign= new ConsultantAssign();
                $branch_assign->consultant_id = $user->id;
                $branch_assign->branch_id = $request->branch_id;
                $branch_assign->save();
            }

            if($request->role_id==11 && !empty($request->agent_manager_id)){
                $agent_assign= new AgentAssign();
                $agent_assign->agent_manager_id = $request->agent_manager_id;
                $agent_assign->agent_id = $user->id;
                $agent_assign->save();
            }
            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'User created successfully.',
                'data'    => $user
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating User: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error creating User.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified user in storage.
     */
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name'    => 'required|string|max:255',
            'email'   => "required|email|unique:users,email,$id",
            'phone'   => "required|string|unique:users,phone,$id",
            'password'=> 'nullable|string|min:6',
        ]);

        try {
            $user = User::findOrFail($id);

            $data = [
                'role_id' => $request->role_id,
                'name'    => $request->name,
                'email'   => $request->email,
                'phone'   => $request->phone,
            ];

            // If password is provided, update it
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return response()->json([
                'status'  => true,
                'message' => 'User updated successfully.',
                'data'    => $user
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating User: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error updating User.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroyUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'status'  => true,
                'message' => 'User deleted successfully.',
                'data'    => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting User: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error deleting User.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function getUserByRole($id){

        try {
            $users = User::where('role_id',$id)->get();
             return response()->json([
                'status'  => true,
                'message' => 'User updated successfully.',
                'data'    => $users
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }

    }


}
