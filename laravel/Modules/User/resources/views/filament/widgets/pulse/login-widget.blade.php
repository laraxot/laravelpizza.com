<x-filament-widgets::widget>
    <x-filament::section
        :heading="__('Accessi utenti')"
        :description="__('Monitoraggio degli ultimi accessi')"
        icon="heroicon-o-users"
    >
        <div class="w-full">
            @livewire(
            \Modules\User\Filament\Widgets\Pulse\LoginCard::class,
            ['cols' => 'full', 'rows' => 2]
            )
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
