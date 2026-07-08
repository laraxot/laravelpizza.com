<?php

declare(strict_types=1);

?>
{{--
    View: user::filament.widgets.login
    Scopo: Widget di login Filament conforme a Windsurf/Xot
    Modifica liberamente questa struttura per UX custom
--}}
<div class="filament-widget-login space-y-6">
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm">
            <div class="font-semibold">{{ __('user::login_widget.ui.errors_title') }}</div>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    <form wire:submit.prevent="save" class="space-y-4">
        {{ $this->form }}
        <button type="submit" class="w-full py-3 rounded bg-[#FF5F7E] text-white font-bold">
            {{ __('user::login_widget.ui.login_button') }}
            <x-filament::loading-indicator class="h-5 w-5" wire:loading/>
        </button>
    </form>
    <div class="text-center text-sm text-gray-500 mt-2">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="underline hover:text-blue-700">{{ __('user::login_widget.ui.forgot_password') }}</a>
        @endif
    </div>
</div>
