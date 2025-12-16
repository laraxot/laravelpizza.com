<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Profile;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Datas\XotData;

class SuperAdmin extends Component
{
    public string $url = '#';

    public ProfileContract $profile;

    public function mount(): void
    {
        $this->profile = XotData::make()->getProfileModel();
        $this->url = url()->current();
    }

    public function toggleSuperAdmin(): RedirectResponse|Redirector
    {
        $this->profile->toggleSuperAdmin();

        return redirect($this->url, 303);
    }

    public function render(): View
    {
        $view = 'user::livewire.profile.super-admin';
        $view_params = [
            'view' => $view,
        ];

        return view($view, $view_params);
    }
}
