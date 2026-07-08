<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AuthLogout extends Component
{
    public function mount(): void
    {
        Auth::logout();
    }

    public function render(): View
    {
        /** @var view-string $viewName */
        $viewName = 'livewire.auth.logout';

        if (! view()->exists($viewName)) {
            throw new \Exception("View {$viewName} not found");
        }

        return view($viewName);
    }
}
