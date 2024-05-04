<?php

namespace App\Livewire;

use Livewire\Component;

class RegistrationPage extends Component
{
    public function render()
    {
        return view('livewire.registration-page')->layout('components.layouts.auth');
    }
}
