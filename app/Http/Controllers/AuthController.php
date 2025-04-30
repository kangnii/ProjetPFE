<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login()
    {

        return view('auth.login');

    }//end method

    public function checkUser(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            if ($user->password == 'CLEAN') {
                return response()->json(['exists' => true, 'cleanPassword' => true]);
            } else {
                return response()->json(['exists' => true, 'cleanPassword' => false]);
            }
        } else {
            return response()->json(['exists' => false]);
        }
    }


    public function LoginFormStore(Request $request)
    {
        // Validation des données du formulaire
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => "Insérer votre email",
            'password.required' => "Insérer votre mot de passe",
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $confirm_password = $request->input('password_confirmation');
        $user = User::where('email', $email)->first();

        // Authentification de l'utilisateur
        if (Auth::attempt($credentials)) {
            // Authentification réussie

            return redirect()->intended('/accueil');

        } else if ($password == $confirm_password) {


            if ($user->password == 'CLEAN') {
                // Mettez à jour le mot de passe avec le nouveau mot de passe haché
                $user->update([
                    'password' => Hash::make($request->input('password'))
                ]);

                // Redirigez l'utilisateur vers le tableau de bord
                return redirect()->intended('/accueil');

            }
        } else if ($password != $confirm_password) {
            // Authentification échouée
            return back()->withErrors(['message' => 'Les mots de passe ne correspondent pas']);

        } else {

            // Authentification échouée
            return back()->withErrors(['message' => 'Email ou mot de passe incorrect.']);
        }
    }

    //end method

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');

    } //end method

    public function profile()
    {
        return view('Squelette.profile');
    }
    public function update_profil(Request $request)
    {
        $user = Auth::user();

        // Validation
        $validated = $request->validate([
            'name'  => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(auth()->user()->id)
            ]
        ]);
        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Informations modifiées avec succès');

    }

    public function update_photo(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png|max:2048'
        ]);

        try {
            if ($request->hasFile('image')) {
                // Suppression de l'ancienne photo si elle existe
                if (auth()->user()->photo) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', auth()->user()->photo));
                }

                // Stockage de la nouvelle photo
                $path = $request->file('image')->store('avatars', 'public');

                // Mise à jour de l'utilisateur
                auth()->user()->update([
                    'photo' => Storage::url($path)
                ]);

                return response()->json([
                    'success' => true,
                    'url' => Storage::url($path),
                    'message' => 'Photo mise à jour avec succès'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Aucun fichier reçu'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Erreur lors du traitement de l'image"
            ], 500);
        }

    }

    public function resetPhoto(Request $request)
    {
        try {
            // Suppression de la photo actuelle
            if (auth()->user()->photo) {
                Storage::disk('public')->delete(str_replace('/storage/', '', auth()->user()->photo));
            }

            // Réinitialisation à null ou à l'image par défaut
            auth()->user()->update([
                'photo' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Photo réinitialisée avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la réinitialisation'
            ], 500);
        }
    }


}
