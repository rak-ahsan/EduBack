<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoList;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TodoListController extends Controller
{
    /**
     * Display a paginated listing of the to-do list.
     */
    public function indexTodoList(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $todoLists = TodoList::when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('task_description', 'LIKE', "%$search%")
                      ->orWhere('status', 'LIKE', "%$search%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data'   => $todoLists
        ], 200);
    }

    /**
     * Store a newly created task in the to-do list.
     */
    public function storeTodoList(Request $request)
    {
        $request->validate([
            'user_executor_id'   => 'required|exists:users,id',
            'user_executor_id'   => 'required',
            'task_duration'      => 'required|date',
            'task_description'   => 'required|string',
            'status'             => 'nullable|in:active,completed,pending',
        ]);

        $assignorId = Auth::id();

        if ($assignorId === (int) $request->user_executor_id) {
            return response()->json([
                'status'  => false,
                'message' => 'A user cannot assign a task to themselves.'
            ], 422);
        }

        try {
            $todoList = TodoList::create([
                'user_assignotor_id' => 1,
                'user_executor_id'   => 2,
                // 'user_assignotor_id' => $assignorId,
                // 'user_executor_id'   => $request->user_executor_id,
                'task_duration'      => $request->task_duration,
                'task_description'   => $request->task_description,
                'status'             => $request->status ?? 'active',
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Task added successfully.',
                'data'    => $todoList
            ], 201);
        } catch (Exception $e) {
            Log::error('Error creating task: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error creating task.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a task in the to-do list.
     */
    public function updateTodoList(Request $request, $id)
    {
        $request->validate([
            'user_executor_id'   => 'required|exists:users,id',
            'task_duration'      => 'required|date',
            'task_description'   => 'required|string',
            'status'             => 'required|in:active,completed,pending',
        ]);

        try {
            $todoList = TodoList::findOrFail($id);

            if ($todoList->user_assignotor_id !== Auth::id()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'You can only update tasks you assigned.'
                ], 403);
            }

            if ($todoList->user_assignotor_id === (int) $request->user_executor_id) {
                return response()->json([
                    'status'  => false,
                    'message' => 'A user cannot assign a task to themselves.'
                ], 422);
            }

            $todoList->update([
                'user_assignotor_id' => 1,
                'user_executor_id'   => 2,
                // 'user_assignotor_id' => $assignorId,
                // 'user_executor_id'   => $request->user_executor_id,
                'task_duration'      => $request->task_duration,
                'task_description'   => $request->task_description,
                'status'             => $request->status,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Task updated successfully.',
                'data'    => $todoList
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating task: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error updating task.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove a task from the to-do list (soft delete).
     */
    public function destroyTodoList($id)
    {
        try {
            $todoList = TodoList::findOrFail($id);

            if ($todoList->user_assignotor_id !== Auth::id()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'You can only delete tasks you assigned.'
                ], 403);
            }

            $todoList->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Task archived successfully.',
                'data'    => null
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting task: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error archiving task.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}