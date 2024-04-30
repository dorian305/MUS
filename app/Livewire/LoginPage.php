<?php

namespace App\Livewire;

use Livewire\Component;

class LoginPage extends Component
{
    public String $title = "MUS";
    public String $description = "A media upload system for easy file storage and retrieval.";

    public function render()
    {
        return view('livewire.login-page');
    }
}
