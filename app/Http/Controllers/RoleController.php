<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|in:user,konselor,admin,super_admin|unique:roles,name',
        ]);

        Role::create($validated);
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function show(Role $role)
    {
        $role->load('users');
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|in:user,konselor,admin,super_admin|unique:roles,name,' . $role->id,
        ]);

        $role->update($validated);
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if ($role->users()->exists()) {
            return redirect()->route('roles.index')->with('error', 'Cannot delete role with associated users.');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}