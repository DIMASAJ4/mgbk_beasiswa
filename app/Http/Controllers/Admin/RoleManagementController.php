<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleManagementController extends Controller
{
    /**
     * Display a listing of users and their assigned roles.
     */
    public function index(Request $request): View
    {
        // Strictly protect this area for Admins only
        if (!$request->user() || !$request->user()->hasRole('Admin')) {
            abort(403, 'Akses Ditolak. Halaman ini hanya untuk Administrator.');
        }

        $users = User::with('roles')->orderBy('name')->get();
        $roles = Role::all();

        return view('admin.roles', compact('users', 'roles'));
    }

    /**
     * Assign a new role to the specified user.
     */
    public function assignRole(Request $request): RedirectResponse
    {
        // Strictly protect this area for Admins only
        if (!$request->user() || !$request->user()->hasRole('Admin')) {
            abort(403, 'Akses Ditolak.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_name' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        
        // Prevent changing current admin's role if they are the only admin
        if ($user->id === $request->user()->id && $request->role_name !== 'Admin') {
            // Check if there are other admins
            $adminCount = User::role('Admin')->count();
            if ($adminCount <= 1) {
                return redirect()->back()->with('error', 'Gagal: Anda adalah satu-satunya Administrator di sistem ini. Anda tidak dapat mengubah peran Anda sendiri.');
            }
        }

        // Sync roles (replaces all existing roles with the selected one)
        $user->syncRoles([$request->role_name]);

        return redirect()->back()->with('success', 'Sukses: Peran ' . $user->name . ' telah diubah menjadi ' . $request->role_name . '!');
    }
}
