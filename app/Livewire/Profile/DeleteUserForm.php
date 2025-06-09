<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeleteUserForm extends Component
{
    public function deleteUser()
    {
        $user = User::find(Auth::id());
        Auth::logout();
        $user->delete();
        $this->dispatchBrowserEvent('user-deleted');
    }

    public function render()
    {
        return view('livewire.profile.delete-user-form');
    }
}
