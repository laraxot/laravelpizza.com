<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget>
    <div class="text-center mb-4">
        <div class="flex justify-center">
            <x-filament::icon
               icon="heroicon-o-exclamation-circle"
               class="h-16 w-16 text-red-500 dark:text-red-400 mt-4" 
            />
        </div>
        <h1 class="mt-4 text-2xl font-bold text-gray-800">{{ __('user::password_expired.title') }}</h1>
        <p class="mt-2 text-gray-600">{{ __('user::password_expired.sub_heading') }}</p>
    </div>
    
    <x-filament-schemas::form wire:submit="resetPassword">
        {{ $this->form }}
        
        <x-filament::button type="submit" class="mt-4">
            @lang('user::password_expired.actions.reset_password.label') <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="submit"/>
        </x-filament::button>
    </x-filament-schemas::form>
</x-filament-widgets::widget>
