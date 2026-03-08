<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt\Password;

use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

/**
 * Summary of ConfirmComponent.
 *
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/auth/password/confirm.blade.php
 */
class ConfirmComponent extends Component
{
    #[Validate('required|current_password')]
    public string $password = '';

    public function confirm(): RedirectResponse
    {
        /*
         * // @var mixed validate([
         * 'password' => ['required', 'current_password'],
         * ]);
         *
         * session()->put('auth.password_confirmed_at', time());
         *
         * // @var mixed redirect(
         * session('url.intended', '/'),
         * navigate: true
         * );
         */
        // @var mixed validate(;

        session()->put('auth.password_confirmed_at', time());

        return redirect()->intended('/');
    }
}
