<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('Squelette.roles', compact('roles', 'permissions'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|unique:roles',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Rôle ajouté !');

    }

    public function edit( Role $role)
    {
        $permissions = Permission::all();
        $permissionsSelected =  $role->permissions()
            ->pluck('id')
            ->toArray();
        return view('Roles.modify_role', compact('role', 'permissions', 'permissionsSelected'));
    }

    public function update(Request $request,Role $role){

        $request->validate([
            'name' => ['required', 'string', Rule::unique('roles')->ignore($role->id)],
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $request->name]);
        $role->permissions()->sync($request->permissions ?? []);
        return redirect()->route('roles.index')->with('success', 'Rôle modifié !');

    }

    public function destroy(Role $role){
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rôle supprimé !');
    }
}
