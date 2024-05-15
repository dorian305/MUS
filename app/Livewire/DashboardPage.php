<?php

namespace App\Livewire;

use App\Models\Media;
use App\Models\User;
use Livewire\Component;

class DashboardPage extends Component
{
    public User $user;
    public Media $media;

    public function render()
    {
        $data = [
            'user' => $this->user,
            'all_media' => $this->user->media,
        ];

        return view("livewire.dashboard-page", $data)
            ->layout("components/layouts/dashboard");
    }
}
