<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Modules\User\Models\User;
use Webmozart\Assert\Assert;

/**
 * Summary of LoginComponent.
 *
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/pages/auth/login.blade.php
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
        /*
         * $credentials = $this->validate([
         * 'email' => ['required', 'email'],
         * 'password' => ['required'],
         * ]);
         *
         * if (auth()->attempt($credentials, $this->remember)) {
         * session()->regenerate();
         *
         * $this->redirect(route('cms.dashboard'));
         * }
         *
         * $this->addError('email', trans('auth.failed'));
         */
        $this->validate();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));

            // return;
            return back(); // ->with('status', 'verification-link-sent');
        }
        $guard = 'web'; // auth()->guard('web')
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 46d657c (.)

        /** @var \Illuminate\Database\Eloquent\Builder<User> $query */
        $query = User::where('email', $this->email);
        $user = $query->first();
<<<<<<< HEAD
=======
        $user = User::where('email', $this->email)->first();
>>>>>>> 76ce10d (.)
=======
>>>>>>> 46d657c (.)
        Assert::isInstanceOf($user, Authenticatable::class);
        $remember = $this->remember;
        event(new Login($guard, $user, $remember));

        // ---
        return redirect()->intended('/');
    }
}
