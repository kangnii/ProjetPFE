<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    public function index(){
        $users = User::with('roles')->paginate(10);
        $roles = Role::all();
        return view('Squelette.users', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'id'); // récupère [id => name]
        return view('Users.user_create', compact('roles'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'role_id'  => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // assignation du rôle
        $role = Role::findById($data['role_id']);
        $user->assignRole($role);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur créé avec succès !');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'Utilisateur supprimé avec succès !');
    }

    public function updateRole(Request $request, $id)
    {
        // récupérer tous les noms de rôles de la BDD
        $validRoles = Role::pluck('name')->toArray();

        $request->validate([
            'role' => ['required', Rule::in($validRoles)],
        ]);

        $user = User::findOrFail($id);
        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Rôle mis à jour avec succès !');
    }
}
