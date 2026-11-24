<?php

declare(strict_types=1);

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use function Laravel\Folio\{middleware, name};

/*
 * Nuova password dal link ricevuto per email (token nell'URL, email nella query string).
 * Dopo il salvataggio l'utente entra subito e arriva alla sua area personale.
 */
middleware(['guest']);
name('password.reset');

new class extends Component
{
    #[Validate('required')]
    public string $token = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:8|same:passwordConfirmation')]
    public string $password = '';

    public string $passwordConfirmation = '';

    public function mount(string $token): void
    {
        $email = request()->query('email', '');
        $this->email = is_string($email) ? $email : '';
        $this->token = $token;
    }

    public function resetPassword(): void
    {
        $this->validate();

        $response = Password::broker()->reset(
            [
                'token' => $this->token,
                'email' => $this->email,
                'password' => $this->password,
            ],
            function ($user, string $password): void {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();

                event(new PasswordReset($user));

                Auth::guard()->login($user);
            },
        );

        if ($response === Password::PASSWORD_RESET) {
            session()->flash('status', (string) trans($response));
            $path = config('xra.post_login_path', '/');
            $this->redirect(LaravelLocalization::localizeUrl(is_string($path) ? $path : '/'));

            return;
        }

        $this->addError('email', (string) trans($response));
    }
};

?>

<x-layouts.app :title="__('pub_theme::auth.password.reset.title')">
    <x-ui.auth-card :title="__('pub_theme::auth.password.reset.title')" :subtitle="__('pub_theme::auth.password.reset.subtitle')">
        @volt('auth.password.token')
            <form wire:submit="resetPassword" class="space-y-6" novalidate>
                <x-ui.auth-field :label="__('pub_theme::auth.password.reset.email')" id="email" type="email" autocomplete="email" wire:model="email" />
                <x-ui.auth-field :label="__('pub_theme::auth.password.reset.password')" id="password" type="password" autocomplete="new-password" autofocus wire:model="password" />
                <x-ui.auth-field :label="__('pub_theme::auth.password.reset.password_confirmation')" id="password_confirmation" type="password" autocomplete="new-password" wire:model="passwordConfirmation" />
                <button type="submit" wire:loading.attr="disabled" class="flex w-full items-center justify-center rounded-xl bg-red-600 px-4 py-3 font-bold text-white shadow-lg shadow-red-900/30 transition hover:bg-red-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-800 disabled:opacity-60">
                    {{ __('pub_theme::auth.password.reset.submit') }}
                </button>
            </form>
        @endvolt
    </x-ui.auth-card>
</x-layouts.app>
