<?php

declare(strict_types=1);

use Livewire\Volt\Component;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['guest']);
name('register');

new class extends Component {
    // Logic is handled by the widget
};

?>

<x-layouts.auth-split>
    <x-slot name="title">
        {{ __('user::login.actions.register.label') }}
    </x-slot>

    <div class="mb-6">
         <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('user::login.register') }}</h2>
         <p class="text-slate-500 dark:text-gray-400">
            {{ __('user::login.already_registered') }}
            <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500 underline decoration-2 decoration-primary-200 hover:decoration-primary-500 transition-all">
                {{ __('user::login.actions.login.label') }}
            </a>
         </p>
    </div>

    @livewire(\Modules\User\Filament\Widgets\Auth\RegisterWidget::class)

</x-layouts.auth-split>
