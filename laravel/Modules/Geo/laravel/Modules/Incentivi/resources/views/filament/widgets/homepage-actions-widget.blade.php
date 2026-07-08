<x-filament-widgets::widget>
    <x-filament::section>

    <div >
        <h5 style="font-size: 1.5rem; font-weight: bold">
        Azioni rapide
        </h5>
        <ul>
            @if (Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('hr-manager'))
            <li>
                <x-filament::button
                    href="../incentivi/admin/workgroups/create"
                    tag="a" color="info" icon="heroicon-m-arrow-long-right" icon-position="after">
                    Nuovo Gruppo di Lavoro
                </x-filament::button>
            </li>
            @endif
            <li>
                <x-filament::button
                    href="../incentivi/admin/projects/create"
                    tag="a" color="primary" icon="heroicon-m-arrow-long-right" icon-position="after">
                    Nuovo Progetto
                </x-filament::button>
            </li>
        </ul>

    </div>
        
    </x-filament::section>
</x-filament-widgets::widget>
