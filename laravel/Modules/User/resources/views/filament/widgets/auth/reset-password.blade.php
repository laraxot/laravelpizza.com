<?php

declare(strict_types=1);
?>
@push('head')
    {{-- Widget Filament in FO: @filamentStyles non copre le pagine pubbliche
         (nessun panel attivo), quindi il CSS Filament va linkato qui.
         Il widget si auto-provisiona: dove viene montato, gli asset ci sono. --}}
    <link rel="stylesheet" href="{{ asset('css/filament/filament/app.css') }}">
@endpush

<div class="space-y-6">
    <div class="text-center">
        <h2 class="text-2xl font-bold tracking-tight">
            {{ __('user::auth.reset_password.title.text') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('user::auth.reset_password.subtitle.text') }}
        </p>
    </div>

    <form wire:submit="resetPassword" class="space-y-6">
        {{ $this->form }}

        <div>
            <x-filament::button
                type="submit"
                class="w-full"
            >
                {{ __('user::auth.reset_password.submit.text') }}
            </x-filament::button>
        </div>
    </form>
</div>
