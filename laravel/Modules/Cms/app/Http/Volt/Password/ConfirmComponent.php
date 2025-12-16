<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt\Password;

use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

/**
 * Summary of ConfirmComponent.
 *
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/pages/auth/password/confirm.blade.php
 */
class ConfirmComponent extends Component
{
    #[Validate('required|current_password')]
    public string $password = '';

    public function confirm(): RedirectResponse
    {
        /*
         * $this->validate([
         * 'password' => ['required', 'current_password'],
         * ]);
         *
         * session()->put('auth.password_confirmed_at', time());
         *
         * $this->redirect(
         * session('url.intended', '/'),
         * navigate: true
         * );
         */
        $this->validate();

        session()->put('auth.password_confirmed_at', time());

        return redirect()->intended('/');
    }
}
