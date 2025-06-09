<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function destroy(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => ['required'],
        ]);

        $user = Auth::user();

        if(!$user instanceof \App\Models\User){
            return response()->json(['message' => 'Error interno: Usuario no válido.'], 500);
        }

        if(!Hash::check($request->password, $user->password)){
            return back()->withErrors(['password' => 'La contraseña no es correcta.']);
        }

        Auth::guard('web')->logout();
        $user->delete();

        return redirect('/')->with('success', 'Cuenta eliminada correctamente.');
    }
}
