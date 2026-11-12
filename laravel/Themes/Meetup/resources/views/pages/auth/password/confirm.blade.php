<?php

declare(strict_types=1);

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

use function Laravel\Folio\{middleware, name};

/* Conferma della password prima di un'area protetta (middleware password.confirm). */
middleware(['auth']);
name('password.confirm');

new class extends Component
{
    #[Validate('required|current_password')]
    public string $password = '';

    public function confirm(): void
    {
        $this->validate();

        session()->put('auth.password_confirmed_at', time());

        $this->redirectIntended('/');
    }
};

?>

<x-layouts.app :title="__('pub_theme::auth.password.confirm.title')">
    <x-ui.auth-card :title="__('pub_theme::auth.password.confirm.title')" :subtitle="__('pub_theme::auth.password.confirm.subtitle')">
        @volt('auth.password.confirm')
            <form wire:submit="confirm" class="space-y-6" novalidate>
                <x-ui.auth-field :label="__('pub_theme::auth.password.confirm.password')" id="password" type="password" autocomplete="current-password" autofocus wire:model="password" />
                <div class="text-right text-sm">
                    <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeUrl('/auth/password/reset') }}" class="font-semibold text-red-400 hover:text-red-300">{{ __('pub_theme::auth.password.confirm.forgot') }}</a>
                </div>
                <button type="submit" wire:loading.attr="disabled" class="flex w-full items-center justify-center rounded-xl bg-red-600 px-4 py-3 font-bold text-white shadow-lg shadow-red-900/30 transition hover:bg-red-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-800 disabled:opacity-60">
                    {{ __('pub_theme::auth.password.confirm.submit') }}
                </button>
            </form>
        @endvolt
    </x-ui.auth-card>
</x-layouts.app>
