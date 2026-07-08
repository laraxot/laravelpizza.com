<x-filament::page>

<table class="table-auto">
   <tbody>
    <tr><td><b>Scheda ID:</b></td><td>[{{ $record->id }}]<br /></td></tr>
<tr><td><b>Lavoratore:</b></td><td> {{ $record->ente }}-{{ $record->matr }}] {{ $record->cognome }} {{ $record->nome }} </td></tr>
{{-- <b>giorni presenza anno</b>: {{ $record->gg_presenza_anno }}<br/> --}}
<tr><td><b>giorni presenza periodo:</b></td><td>{{ $record->gg_presenza_periodo }} 
@hasrole('super-admin')
 <x-filament::input.wrapper>
    <x-filament::input type="number" step="1" wire:model="form_data.tot_presenza_periodo_plus_no_timbr" />
    @error('form_data.tot_presenza_periodo_plus_no_timbr') <span class="text-danger-600 hover:text-danger-700">{{ $message }}</span> @enderror
</x-filament::input.wrapper>
@endhasrole
</td>
</tr>

<tr><td><b>Quadrimestre N:</b></td><td> {{ $record->quadrimestre }} </td></tr>
@php
 $q=$record->quadrimestre;
 $dal=\Carbon\Carbon::parse($this->getRecord()->anno.'-01-01')->addMonths(4 * ($q - 1));
$al=\Carbon\Carbon::parse($this->getRecord()->anno.'-01-01')->addMonths(4 * ($q ))->subDays(1);
@endphp

<tr><td><b>Dal</b></td><td> {{ $dal->format('d/m/Y') }} - <b>Al</b> {{ $al->format('d/m/Y') }} </td></tr>
<tr><td><b>Perc P Time Anno:</b> </td><td>{{ number_format($record->perc_p_time_year * 100, 2) }} % </td></tr>
<tr><td><b>Perc P Time intervallo di date:</b> </td><td>{{ number_format($record->perc_p_time_daterange * 100, 2) }} % </td></tr>
{{--
<tr><td><b>Qualifica:</b></td><td> {{ $record->codqua }}] {{ $record->codqua_txt }} </td></tr>
<tr><td><b>Disciplina:</b> </td><td>{{ $record->disci1 }}]{{ $record->disci1_txt }} </td></tr>
    --}}
</table>

<table class="table-auto">
    <thead>
        <tr> 
            <th>Descrizione</th> 
            <th>Giorni</th>
            <th>€<br/>giorno</th>
            <th>€<br/>tot</th>
        </tr>
    </thead>
    <tbody>
    @foreach($record->indennitaTipoDettaglio as $dettaglio)
        <tr class="border border-gray-400  " wire:key="dettaglio-{{ $dettaglio->id }}">
        <td >{{ $dettaglio->nome }}</td>
        <td> 
            {{ $dettaglio->pivot_gg }}
            {{--
            <input type="number" step="1" wire:model="form_data.dettaglio.{{ $dettaglio->id}}.pivot.gg"  style="text-align:right;" /> 
             --}}
            <x-filament::input.wrapper>
                <x-filament::input
                    type="number"
                    wire:model.live.number="form_data.dettaglio.{{ $dettaglio->id}}.pivot.gg"
                />
            </x-filament::input.wrapper>
            
        </td>
        <td style="padding:5px;border-right:5px darkgray;"> @money($dettaglio->euro_giorno,'EUR') </td>
        <td> @money($dettaglio->euro_giorno *  intval($form_data['dettaglio'][$dettaglio->id]['pivot']['gg']),'EUR') </td>
        </tr>
        {{--
        <tr>
            <td colspan="4">
                <pre class="whitespace-pre-wrap">{{ json_encode($form_data['dettaglio'][$dettaglio->id]['pivot'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </td>
        </tr>
        --}}
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="1" align="right"><b>Tot</b></td>
        <td align="right"><b>{{ $form_data['tot_gg'] }}</b></td>
        <td></td>
        <td align="right"><b>@money($form_data['tot_euro'],'EUR')</b></td>
    </tr>
    </tfoot>
</table>

@if ($errors->any())
    <div class="text-danger-600 hover:text-danger-700">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mt-4 flex items-center gap-3">
    <x-filament::button type="button" wire:click="back()" icon="heroicon-o-arrow-uturn-left" > 
        Back 
    </x-filament::button>
    <x-filament::button type="button" form="authenticate" wire:click="save()" icon="heroicon-o-arrow-up-circle">
       Salva
    </x-filament::button>
</div>

</x-filament::page>