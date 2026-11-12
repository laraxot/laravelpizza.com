<?php

declare(strict_types=1);

use Livewire\Volt\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use function Laravel\Folio\{middleware, name};

/*
 * Avviso "verifica la tua email" con il pulsante per riceverne un'altra.
 * Rimandare il link NON segna l'email come verificata (prima partiva l'evento Verified a ogni invio).
 */
middleware(['auth', 'throttle:6,1']);
name('verification.notice');

new class extends Component
{
    public bool $resent = false;

    public function mount(): void
    {
        // Email già verificata: niente da fare qui, si va all'area personale.
        if (auth()->user()?->hasVerifiedEmail() === true) {
            $path = config('xra.post_login_path', '/');
            $this->redirect(LaravelLocalization::localizeUrl(is_string($path) ? $path : '/'));
        }
    }

    public function resend(): void
    {
        $user = auth()->user();
        if ($user === null) {
            return;
        }

        if ($user->hasVerifiedEmail()) {
            $path = config('xra.post_login_path', '/');
            $this->redirect(LaravelLocalization::localizeUrl(is_string($path) ? $path : '/'));

            return;
        }

        $user->sendEmailVerificationNotification();
        $this->resent = true;
    }
};

?>

<x-layouts.app :title="__('pub_theme::auth.verify.title')">
    <x-ui.auth-card :title="__('pub_theme::auth.verify.title')" :subtitle="__('pub_theme::auth.verify.subtitle')">
        @volt('auth.verify')
            <div class="space-y-6">
                @if ($resent)
                    <div class="flex items-start gap-3 rounded-xl border border-green-500/30 bg-green-500/10 p-4 text-sm text-green-200" role="status">
                        <x-heroicon-o-check-circle class="h-5 w-5 shrink-0 text-green-400" aria-hidden="true" />
                        <p>{{ __('pub_theme::auth.verify.resent') }}</p>
                    </div>
                @endif
                <button type="button" wire:click="resend" wire:loading.attr="disabled" class="flex w-full items-center justify-center rounded-xl bg-red-600 px-4 py-3 font-bold text-white shadow-lg shadow-red-900/30 transition hover:bg-red-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-800 disabled:opacity-60">
                    {{ __('pub_theme::auth.verify.resend') }}
                </button>
            </div>
        @endvolt

        <form method="POST" action="{{ route('logout') }}" class="mt-8 border-t border-slate-700 pt-6 text-center">
            @csrf
            <button type="submit" class="text-sm font-semibold text-slate-300 underline-offset-4 hover:text-white hover:underline">{{ __('pub_theme::auth.verify.logout') }}</button>
        </form>
    </x-ui.auth-card>
</x-layouts.app>
