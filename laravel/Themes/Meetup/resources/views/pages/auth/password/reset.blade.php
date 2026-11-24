<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

use function Laravel\Folio\{middleware, name};

/*
 * "Password dimenticata": chiede l'email e manda il link per sceglierne una nuova.
 * Il messaggio è lo stesso che l'email esista o no (nessuna enumerazione degli account).
 */
middleware(['guest', 'throttle:6,1']);
name('password.request');

new class extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    public ?string $emailSentMessage = null;

    public function sendResetPasswordLink(): void
    {
        $this->validate();

        $response = Password::broker()->sendResetLink(['email' => $this->email]);

        if ($response === Password::INVALID_USER || $response === Password::RESET_LINK_SENT) {
            $this->emailSentMessage = (string) trans(Password::RESET_LINK_SENT);

            return;
        }

        $this->addError('email', (string) trans($response));
    }
};

?>

<x-layouts.app :title="__('pub_theme::auth.password.request.title')">
    <x-ui.auth-card :title="__('pub_theme::auth.password.request.title')" :subtitle="__('pub_theme::auth.password.request.subtitle')">
        @volt('auth.password.reset')
            <div>
                @if ($emailSentMessage)
                    <div class="flex items-start gap-3 rounded-xl border border-green-500/30 bg-green-500/10 p-4 text-sm text-green-200" role="status">
                        <x-heroicon-o-check-circle class="h-5 w-5 shrink-0 text-green-400" aria-hidden="true" />
                        <p>{{ $emailSentMessage }}</p>
                    </div>
                @else
                    <form wire:submit="sendResetPasswordLink" class="space-y-6" novalidate>
                        <x-ui.auth-field :label="__('pub_theme::auth.password.request.email')" id="email" type="email" autocomplete="email" autofocus wire:model="email" />
                        <button type="submit" wire:loading.attr="disabled" class="flex w-full items-center justify-center rounded-xl bg-red-600 px-4 py-3 font-bold text-white shadow-lg shadow-red-900/30 transition hover:bg-red-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-800 disabled:opacity-60">
                            {{ __('pub_theme::auth.password.request.submit') }}
                        </button>
                    </form>
                @endif
            </div>
        @endvolt

        <p class="mt-8 border-t border-slate-700 pt-6 text-center text-sm">
            <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeUrl('/auth/login') }}" class="font-semibold text-red-400 transition-colors hover:text-red-300">
                &larr; {{ __('pub_theme::auth.password.request.back_to_login') }}
            </a>
        </p>
    </x-ui.auth-card>
</x-layouts.app>
