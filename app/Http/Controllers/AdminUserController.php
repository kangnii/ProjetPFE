<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(){
        $users = User::paginate(10);
        return view('Squelette.users', compact('users'));
    }

    public function create()
    {
        return view('Users.user_create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur créé avec succès !');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'Utilisateur supprimé avec succès !');
    }
}
