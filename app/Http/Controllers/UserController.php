<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function __construct()
    {
        Gate::authorize('admin');
    }

    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $users = User::query();

            return DataTables::of($users)
                ->addColumn('actions', function ($row) {
                    return '
                        <button class="btn btn-warning btn-sm edit-btn" data-id="' . $row->id . '">Editar</button>
                        <button class="btn btn-info btn-sm status-btn" data-id="' . $row->id . '">Mudar Status</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Delete</button>
                    ';
                })
                ->editColumn('status', function ($row) {
                    return $row->status ? 'Ativo' : 'Inativo';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('users.index');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = true;

        $user = User::create($validated);

        return response()->json(['message' => 'User created successfully.', 'user' => $user], 201);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
        ]);

        $user->update($validated);

        return response()->json(['message' => 'User updated successfully.', 'user' => $user]);
    }

    /**
     * Toggle the status of the user (activate/deactivate).
     */
    public function toggleStatus(User $user)
    {

        $user->update(['status' => !$user->status]);

        return response()->json(['message' => 'User status updated successfully.', 'user' => $user]);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {

        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }
}
