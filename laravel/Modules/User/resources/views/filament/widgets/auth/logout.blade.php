<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-6">
            @if (session('error'))
                <div class="p-4 border border-danger-600 bg-danger-500/10 rounded-lg">
                    <p class="text-danger-600 text-sm">
                        {{ session('error') }}
                    </p>
                </div>
            @endif

            <form wire:submit="logout">
                {{ $this->form }}

                <div class="mt-6 flex flex-col gap-3">
                    <x-filament::button 
                        type="submit"
                        color="danger"
                        size="lg"
                        class="w-full justify-center"
                        :disabled="$isLoggingOut">
                        {{ __('Conferma Logout') }}
                    </x-filament::button>

                    <x-filament::button 
                        tag="a" 
                        :href="'/' . app()->getLocale()"
                        color="gray"
                        size="lg"
                        class="w-full justify-center">
                        {{ __('Annulla') }}
                    </x-filament::button>
                </div>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
