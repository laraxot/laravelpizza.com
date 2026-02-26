<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Modules\User\Models\User;
use Webmozart\Assert\Assert;

/**
 * Summary of LoginComponent.
 *
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/auth/login.blade.php
 */
class LoginComponent extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    public function authenticate(): RedirectResponse
    {
        $this->validate();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));

            return back();
        }

        $guard = 'web';

        /** @var Builder<User> $query */
        $query = User::where('email', $this->email);
        $user = $query->first();

        Assert::isInstanceOf($user, Authenticatable::class);
        $remember = $this->remember;
        event(new Login($guard, $user, $remember));

        return redirect()->intended('/');
    }
}
