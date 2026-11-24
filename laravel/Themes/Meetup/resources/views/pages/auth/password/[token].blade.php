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

<<<<<<< .merge_file_OO6f15
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
=======
<x-layouts.main>
    <div class="flex flex-col items-stretch justify-center w-screen min-h-screen py-10 sm:items-center">

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-ui.link href="{{ route('home') }}">
                <x-ui.logo class="w-auto h-10 mx-auto text-gray-700 fill-current dark:text-gray-100" />
                <x-ui.logo class="w-auto h-10 mx-auto text-gray-700 fill-current dark:text-gray-100" />
            </x-ui.link>
            <h2 class="mt-5 text-2xl font-extrabold leading-9 text-center text-gray-800 dark:text-gray-200">{{ __('pub_theme::auth.password.reset.title') }}</h2>
        </div>
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="px-10 py-0 sm:py-8 sm:shadow-sm sm:bg-white dark:sm:bg-gray-950/50 dark:border-gray-200/10 sm:border sm:rounded-lg border-gray-200/60">
                @volt('auth.password.token')
                <form wire:submit="resetPassword" class="space-y-6">
                    <x-ui.input :label="__('pub_theme::auth.password.email.label')" type="email" id="email" name="email" wire:model="email" />
                    <x-ui.input :label="__('pub_theme::common.fields.password.label')" type="password" id="password" name="password" wire:model="password" />
                    <x-ui.input :label="__('pub_theme::auth.password.confirm_field.label')" type="password" id="password_confirmation" name="password_confirmation" wire:model="passwordConfirmation" />
                    <x-ui.button type="primary" rounded="md" submit="true">{{ __('pub_theme::auth.password.reset.label') }}</x-ui.button>
                </form>
                @endvolt
            </div>
        </div>
    </div>
</x-layouts.main>
>>>>>>> .merge_file_VuJdjQ
