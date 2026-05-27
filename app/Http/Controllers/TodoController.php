<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $query = Todo::where('user_id', $request->user()->id);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Priority filter
        if ($request->filled('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        if ($sortBy === 'priority') {
            $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low') {$sortOrder}");
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $todos = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $todos,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['nullable', Rule::in(['pending', 'in_progress', 'completed'])],
            'priority' => ['nullable', Rule::in(['low', 'medium', 'high'])],
            'due_date' => 'nullable|date',
        ]);

        $todo = $request->user()->todos()->create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo created successfully',
            'data' => $todo,
        ], 201);
    }

    public function show(Request $request, Todo $todo)
    {
        if ($todo->user_id !== $request->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access to todo item'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $todo,
        ]);
    }

    public function update(Request $request, Todo $todo)
    {
        if ($todo->user_id !== $request->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access to todo item'
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['sometimes', Rule::in(['pending', 'in_progress', 'completed'])],
            'priority' => ['sometimes', Rule::in(['low', 'medium', 'high'])],
            'due_date' => 'nullable|date',
        ]);

        $todo->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo updated successfully',
            'data' => $todo,
        ]);
    }

    public function destroy(Request $request, Todo $todo)
    {
        if ($todo->user_id !== $request->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access to todo item'
            ], 403);
        }

        $todo->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Todo deleted successfully',
        ]);
    }

    public function toggleStatus(Request $request, Todo $todo)
    {
        if ($todo->user_id !== $request->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access to todo item'
            ], 403);
        }

        $newStatus = $todo->status === 'completed' ? 'pending' : 'completed';
        $todo->update(['status' => $newStatus]);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo status toggled successfully',
            'data' => $todo,
        ]);
    }
}
