<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            if ($user->password === 'CLEAN') {
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
        // Étape 1 : Validation de base
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => "Insérer votre email",
            'password.required' => "Insérer votre mot de passe",
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $confirmPassword = $request->input('password_confirmation');

        // Étape 2 : Vérifier si l'utilisateur existe
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['message' => 'Aucun utilisateur trouvé avec cet email.']);
        }

        // Étape 3 : Mot de passe temporaire "CLEAN"
        if ($user->password === 'CLEAN') {

            // Si le champ de confirmation est vide
            if (!$confirmPassword) {
                return back()->withErrors(['message' => 'Veuillez confirmer le mot de passe.']);
            }

            // Vérification de correspondance
            if ($password !== $confirmPassword) {
                return back()->withErrors(['message' => 'Les mots de passe ne correspondent pas.']);
            }

            // Mise à jour du mot de passe
            $user->password = Hash::make($password);
            $user->save();

            // Connexion automatique
            Auth::login($user);
            return redirect()->intended('/accueil');
        }

        // Étape 4 : Tentative de connexion classique
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->intended('/accueil');
        }

        // Échec d'authentification
        return back()->withErrors(['message' => 'Email ou mot de passe incorrect.']);
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

    public function gestion(){
        $users = User::where('id', '!=', 26)->get();
        return view('Squelette.gestion', compact('users'));
    }

    public function password(Request $request){

        $user = Auth::user();
             $request->validate([
            'password' => 'required',
            'new_password' => 'required|string',
            'confirm_password' => 'required|string|same:new_password',
        ]);

        if (Hash::check($request->input('password'), $user->password)) {
            $user->update(['password' => Hash::make($request->input('new_password'))]);
            return redirect()->route('profil.gestion')->with('success','Mot de passe mis à jour avec succès');
        }else{
            return back()->withErrors(['message' => 'Changement échoué. Le mot de passe de votre compte est incorrect']);
        }


    }

    public function toggleActiveStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->back()->with('status', "L'utilisateur a été " . ($user->is_active ? 'activé' : 'désactivé') . '.');
    }

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

}
