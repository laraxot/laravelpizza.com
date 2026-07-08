<x-filament-panels::page>
    {{ $this->form }}

    <x-filament::actions
        :actions="$this->getFormActions()"
    />
</x-filament-panels::page>