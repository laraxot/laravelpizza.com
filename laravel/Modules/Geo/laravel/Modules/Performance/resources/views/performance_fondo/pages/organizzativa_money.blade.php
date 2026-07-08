<x-filament::page>
    <div class="space-y-4">
        <h2 class="text-lg font-semibold">{{ $title }}</h2>

        @if(empty($organizzativaSenzaValutatore))
            <x-filament::section>
                <x-slot name="heading">
                    {{ __('performance::performance_fondo.pages.organizzativa_money.valutatore_check.title.label') }}
                </x-slot>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('performance::performance_fondo.pages.organizzativa_money.valutatore_check.empty.label') }}
                </p>
            </x-filament::section>
        @else
            <x-filament::section>
                <x-slot name="heading">
                    {{ __('performance::performance_fondo.pages.organizzativa_money.valutatore_check.title.label') }}
                </x-slot>
                <x-slot name="description">
                    {{ __('performance::performance_fondo.pages.organizzativa_money.valutatore_check.description.label', ['year' => $year, 'type' => $type]) }}
                </x-slot>
                <ul class="list-inside list-disc space-y-1 text-sm">
                    @foreach ($organizzativaSenzaValutatore as $row)
                        <li>
                            {{ __('performance::performance_fondo.pages.organizzativa_money.valutatore_check.row.label', [
                                'id' => $row['id'],
                                'matr' => $row['matr'] ?? '—',
                                'cognome' => $row['cognome'] ?? '',
                                'nome' => $row['nome'] ?? '',
                                'stabi' => $row['stabi'] ?? '—',
                                'repar' => $row['repar'] ?? '—',
                            ]) }}
                        </li>
                    @endforeach
                </ul>
            </x-filament::section>
        @endif
    </div>
</x-filament::page>