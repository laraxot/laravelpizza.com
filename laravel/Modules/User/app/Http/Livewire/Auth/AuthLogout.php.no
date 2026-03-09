<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Auth;

use Livewire\Component;

class AuthLogout extends Component
{
    public function mount(): void
    {
        auth()->logout();
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
