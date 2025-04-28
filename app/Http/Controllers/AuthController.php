<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){

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
        ],[
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

        } else if($password == $confirm_password) {


            if ($user->password == 'CLEAN') {
                // Mettez à jour le mot de passe avec le nouveau mot de passe haché
                $user->update([
                    'password' => Hash::make($request->input('password'))
                ]);

                // Redirigez l'utilisateur vers le tableau de bord
                return redirect()->intended('/accueil');

            }
        }else if($password != $confirm_password){
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

    public function profile(Request $request){

//        $user = User::find(Auth::user());
//
//        // Validation
//        $request->validate([
//            'name'  => 'required|string',
//            'email' => 'required|email',
//            'password' => 'required',
//            'password_conf'     => 'required',
//        ]);

        return view('Squelette.profile');
    }



}
