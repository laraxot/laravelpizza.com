@php
    use Filament\Forms\Get;
    use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Database\Eloquent\Builder;
    
    $anno = $get('anno');
    if (!$anno) {
        return;
    }
    
    $cessatiRecords = IndennitaResponsabilita::where('anno', (int) $anno)
        ->whereNotExists(function (Builder $query) use ($anno) {
            $query->select(DB::raw(1))
                ->from('rep00f')
                ->whereColumn('rep00f.matr', 'indennita_responsabilita.matr')
                ->where('rep00f.repann', '')
                ->where('rep00f.ente', 90)
                ->whereYear('rep00f.repdal', '<=', $anno)
                ->where(function (Builder $q) use ($anno) {
                    $q->whereNull('rep00f.repal')
                       ->orWhereYear('rep00f.repal', '>=', $anno);
                });
        })
        ->limit(50) // Limit display to prevent performance issues
        ->get();
@endphp

@if ($cessatiRecords->count() > 0)
    <div class="space-y-2">
        <div class="text-sm text-gray-600 mb-2">
            {{ __('ptv::scheda.actions.showing_records', ['count' => $cessatiRecords->count(), 'total' => $cessatiRecords->count()]) }}
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Matricola
                        </th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cognome
                        </th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nome
                        </th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Stabilimento
                        </th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Reparto
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($cessatiRecords as $record)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ $record->matr }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ $record->cognome }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ $record->nome }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ $record->stabi }} - {{ $record->stabi_txt }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ $record->repar }} - {{ $record->repar_txt }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if ($cessatiRecords->count() >= 50)
            <div class="text-sm text-amber-600 mt-2">
                {{ __('ptv::scheda.actions.showing_limited_results') }}
            </div>
        @endif
    </div>
@endif