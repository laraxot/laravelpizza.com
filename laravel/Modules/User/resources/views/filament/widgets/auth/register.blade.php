<?php

declare(strict_types=1);
?>
{{--
    View: user::filament.widgets.auth.register (vestito convenzionale di Modules\User\Filament\Widgets\Auth\RegisterWidget).
    Senza questo file GetViewByClassAction non trova nessuna vista e il widget ricade su xot::filament.widgets.base,
    che stampa «widget astratto» al posto del form (A11Y-001).
    E' il ripiego senza consensi: per la registrazione con privacy e condizioni usare Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget.
    Un tema puo' sostituirlo con pub_theme::filament.widgets.auth.register.
--}}
@push('head')
    {{-- Widget Filament in FO: @filamentStyles non copre le pagine pubbliche
         (nessun panel attivo), quindi il CSS Filament va linkato qui.
         Il widget si auto-provisiona: dove viene montato, gli asset ci sono. --}}
    <link rel="stylesheet" href="{{ asset('css/filament/filament/app.css') }}">
@endpush

<div class="space-y-6">
    <form wire:submit="save" novalidate class="space-y-6">
        {{ $this->form }}

        <x-filament::button type="submit" class="w-full" wire:loading.attr="disabled" wire:target="save">
            {{ __('user::login.actions.register.label') }}
        </x-filament::button>
    </form>

    <p class="text-center text-sm text-gray-700">
        {{ __('user::registration.already_registered') }}
        <a href="{{ route('login') }}" class="font-semibold underline">{{ __('user::auth.login.title.text') }}</a>
    </p>
</div>
