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

        if (!Auth::attempt(['email' => $email, 'password' => $this->password], $this->remember
            $this->addError('email', trans('auth.failed'));

            return;
        }

        event(new Login(auth()->guard('web'), User::where('email', $email)));

        return redirect()->intended('/');
    }
};

?>

<x-layouts.guest>
    <x-slot name="title">
        {{ __('user::login.title') }}
    </x-slot>
    <x-slot name="subtitle">
        {{ __('user::login.subtitle_start') }}
        <x-ui.text-link href="{{ route('register') }}">{{ __('user::login.subtitle_link') }}</x-ui.text-link>
    </x-slot>

    @volt('auth.login')
    <form wire:submit="authenticate" class="space-y-6">

        <x-ui.input 
            label="{{ __('user::login.fields.email.label') }}" 
            type="email" 
            id="email" 
            name="email" 
            wire:model="email" 
            placeholder="{{ __('user::login.fields.email.placeholder') }}"
        />

        <x-ui.input 
            label="{{ __('user::login.fields.password.label') }}" 
            type="password" 
            id="password" 
            name="password" 
            wire:model="password" 
            placeholder="{{ __('user::login.fields.password.placeholder') }}"
        />

        <div class="flex items-center justify-between mt-6 text-sm leading-5">
            <x-ui.checkbox 
                label="{{ __('user::login.fields.remember.label') }}" 
                id="remember" 
                name="remember" 
                wire:model="remember" 
            />
            <x-ui.text-link href="{{ route('password.request') }}">{{ __('user::login.actions.forgot_password.label') }}</x-ui.text-link>
        </div>

        <x-ui.button type="primary" rounded="md" submit="true" class="w-full flex justify-center">
            {{ __('user::login.actions.login.label') }}
        </x-ui.button>
    </form>
    @endvolt

</x-layouts.guest>
