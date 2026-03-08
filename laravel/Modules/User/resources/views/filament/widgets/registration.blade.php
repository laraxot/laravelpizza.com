<?php

declare(strict_types=1);

?>
<x-filament::widget>
    <x-filament::section>
        <form wire:submit="register">
            {{ $form }}

            <x-filament::button 
                type="submit"
                class="w-full mt-6"
            >
                Registrati
            </x-filament::button>
        </form>
    </x-filament::section>
</x-filament::widget>
