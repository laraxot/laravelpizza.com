<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget>
    <x-filament::section>
        <form wire:submit="submit">
            {{ $this->form }}

            <div class="mt-4">
                <x-filament::button
                    type="submit"
                    color="primary"
                >
                    {{ __('geo::widgets.location.submit') }}
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
