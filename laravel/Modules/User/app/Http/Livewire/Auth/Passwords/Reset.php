<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Auth\Passwords;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Xot\Actions\File\ViewCopyAction;
use Webmozart\Assert\Assert;

class Reset extends Component
{
    public string $token = '';

    public string $email = '';

    public string $password = '';

    public string $passwordConfirmation = '';

    public function mount(string $token): void
    {
        Assert::string($email = request()->query('email', ''));
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Reimposta la password dell'utente.
     */
    public function resetPassword(): Redirector|RedirectResponse|null
    {
        $messages = __('user::validation');

        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'same:passwordConfirmation', PasswordRule::defaults()],
        ], $messages);

        $response = $this->broker()->reset(
            [
                'token' => $this->token,
                'email' => $this->email,
                'password' => $this->password,
            ],
            function (Authenticatable $user, string $password): void {
                /* @var Model&Authenticatable $user */
                $user->setAttribute('password', Hash::make($password));
                $user->setRememberToken(Str::random(60));
                $user->save();

                event(new PasswordReset($user));

                $this->guard()->login($user);
            },
        );

        /* @phpstan-ignore argument.type */
        Assert::string($response_lang = trans((string) $response));

        if (Password::PASSWORD_RESET === $response) {
            session()->flash($response_lang);

            return redirect(route('home'));
        }

        $this->addError('email', $response_lang);

        return null;
    }

    /**
     * Get the broker to be used during password reset.
     */
    public function broker(): PasswordBroker
    {
        return Password::broker();
    }

    public function render(): View|Factory
    {
        app(ViewCopyAction::class)
            ->execute('user::livewire.auth.passwords.reset', 'pub_theme::livewire.auth.passwords.reset');
        app(ViewCopyAction::class)->execute('user::layouts.auth', 'pub_theme::layouts.auth');
        app(ViewCopyAction::class)->execute('user::layouts.base', 'pub_theme::layouts.base');

        /**
         * @phpstan-var view-string
         */
        $view = 'pub_theme::livewire.auth.passwords.reset';

        return view($view, [
            'layout' => 'pub_theme::layouts.auth',
        ]);
    }

    /**
     * Get the guard to be used during password reset.
     */
    protected function guard(): StatefulGuard
    {
        return Auth::guard();
    }
}
