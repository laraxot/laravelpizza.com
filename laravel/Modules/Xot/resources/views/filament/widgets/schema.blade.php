<?php

declare(strict_types=1);

/**
 * Vista default per widget che estendono XotBaseSchemaWidget.
 *
 * Le sottoclassi di solito overridano $view con una vista del tema
 * (es. user::widgets.auth.login-widget). Questa vista è il fallback
 * "nudo" che mostra solo il form, utile per debug o widget headless.
 *
 * Zen: il widget è il direttore d'orchestra, la *Form è lo spartito,
 * la vista è il vestito. Mai mettere logica di form nella vista.
 */
?>
<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot:heading>
            {{ $this->title ?? '' }}
        </x-slot:heading>

        <form wire:submit.prevent="submit" class="space-y-4">
            {{ $this->form }}

            <div class="flex justify-end">
                <x-filament::button type="submit" color="primary">
                    {{ __('xot::widgets.schema.submit.label') }}
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
