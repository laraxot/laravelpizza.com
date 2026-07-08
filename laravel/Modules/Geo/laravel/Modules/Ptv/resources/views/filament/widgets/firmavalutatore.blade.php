<x-filament::widget>
    <x-filament::section>
        <x-slot name="heading">
            Firma
        </x-slot>
        {{ $this->form }}
        
        <x-filament::actions :actions="$this->getFormActions()" />
    </x-filament::section>
</x-filament::widget>