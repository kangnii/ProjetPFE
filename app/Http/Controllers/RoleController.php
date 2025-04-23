<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);
        dd($request->all());

        return redirect()->route('roles.index')->with('success', 'Rôle ajouté !');

    }

    public function edit( Role $role )
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request,Role $role){

        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);
        return redirect()->route('roles.index')->with('success', 'Rôle modifié !');

    }

    public function destroy(Role $role){
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rôle supprimé !');
    }
}
