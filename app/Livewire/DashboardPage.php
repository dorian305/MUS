<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class DashboardPage extends Component
{
    public User $user;

    public function render()
    {
        return view('livewire.dashboard-page')->layout("components.layouts.dashboard");
    }
}
