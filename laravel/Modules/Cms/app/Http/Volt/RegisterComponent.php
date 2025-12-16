<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Modules\User\Models\User;

/**
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/pages/auth/register.blade.php
 */
#[Layout('cms::layouts.auth')]
class RegisterComponent extends Component
{
    #[Validate('required')]
    public string $name = '';

    #[Validate('required|email|unique:users')]
    public string $email = '';

    #[Validate('required|min:8|same:password_confirmation')]
    public string $password = '';

    #[Validate('required|min:8|same:password')]
    public string $password_confirmation = '';

    public function register(): RedirectResponse
    {
        $this->validate();

        /** @var User $user */
        $user = User::create([
            'email' => $this->email,
            'name' => $this->name,
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended('/');
    }
}
