<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UpdatePasswordForm extends Component
{
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public function updatePassword(){
        $this->validate([
            'state.current_password' => 'required',
            'state.password' => 'required|min:8|confirmed',
        ]);

        $user = \App\Models\User::find(Auth::id());

        if (!\Illuminate\Support\Facades\Hash::check($this->state['current_password'], $user->password)) {
            session()->flash('error', 'La contraseña actual no es correcta.');
            return;
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($this->state['password']);
        $user->save();

        Auth::login($user); // <- Esto mantiene la sesión

        session()->flash('success', 'Contraseña actualizada correctamente.');
        $this->reset('state');
    }
}
