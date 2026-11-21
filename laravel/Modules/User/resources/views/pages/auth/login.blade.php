<?php

declare(strict_types=1);
use Modules\User\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Login;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['guest']);
name('login');

new class extends Component {
    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

    public $remember = false;

    public function authenticate()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('user::login.actions.login.error'));

            return;
        }

        event(new Login(auth()->guard('web'), User::where('email', $this->email)->first(), $this->remember));

        return redirect()->intended('/');
    }
};

?>
{{--
  Ripiego del modulo: un tema che ha pages/auth/login.blade.php la sostituisce (Folio usa prima il tema).
  Prima la pagina non aveva markup: il componente Volt `auth.login` non si poteva montare (Livewire senza tag radice).
--}}
<x-layouts.app :title="__('user::login.title')">
    @volt('auth.login')
        <div class="mx-auto max-w-md px-4 py-12">
            <h1 class="text-2xl font-semibold">{{ __('user::login.title') }}</h1>
            <form wire:submit="authenticate" class="mt-6 space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium">{{ __('user::login.fields.email.label') }}</label>
                    <input id="email" type="email" wire:model="email" autocomplete="email" required class="mt-1 block w-full rounded-lg border px-3 py-2">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium">{{ __('user::login.fields.password.label') }}</label>
                    <input id="password" type="password" wire:model="password" autocomplete="current-password" required class="mt-1 block w-full rounded-lg border px-3 py-2">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" wire:model="remember">
                    {{ __('user::login.fields.remember.label') }}
                </label>
                <button type="submit" class="w-full rounded-lg bg-blue-600 px-4 py-2 font-medium text-white">
                    {{ __('user::login.actions.login.label') }}
                </button>
            </form>
        </div>
    @endvolt
</x-layouts.app>
