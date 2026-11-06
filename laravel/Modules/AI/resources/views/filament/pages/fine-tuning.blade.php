<x-filament-panels::page>
     {{-- Form di fine-tuning --}}
    <form wire:submit.prevent="startFineTuning">
        {{-- Renderizza il form generato nel controller --}}
        {{ $this->form }}

        {{-- Filament v4: replace deprecated actions component with a submit button --}}
        <x-filament::button type="submit">
            {{ __('ai::fine_tuning_page.actions.start.label') }}
        </x-filament::button>
    </form>
 </x-filament-panels::page>
