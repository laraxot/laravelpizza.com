<x-filament::page>
<h3 class="fi-header-heading text-2xl ">{!! $record->msg('titolo') !!}</h3>

<table class="table-auto">
   <tbody>
    <tr>
        <td><b>Scheda ID:</b></td>
        <td>[{{ $record->id }}]<br /></td>
    </tr>
    <tr>
        <td><b>Lavoratore:</b></td>
        <td> {{ $record->ente }}-{{ $record->matr }}] {{ $record->cognome }} {{ $record->nome }} </td>
        
    </tr>
    <tr>
        <td><b>Perc P Time Anno:</b> </td>
        <td>{{ number_format($record->perc_p_time_year * 100, 2) }} % </td>
    </tr>

{{-- <b>giorni presenza anno</b>: {{ $record->gg_presenza_anno }}<br/> --}}
{{--
<tr><td><b>giorni presenza periodo:</b></td><td>{{ $record->gg_presenza_periodo }} 
<input type="number" step="1" wire:model="form_data.tot_presenza_periodo_plus_no_timbr" />
@error('form_data.tot_presenza_periodo_plus_no_timbr') <span class="text-danger-600 hover:text-danger-700">{{ $message }}</span> @enderror
</td></tr>
<tr><td><b>Dal</b></td><td> {{ $dal->format('d/m/Y') }} - <b>Al</b> {{ $al->format('d/m/Y') }} </td></tr>
<tr><td><b>Perc P Time Anno:</b> </td><td>{{ number_format($record->perc_p_time_year * 100, 2) }} % </td></tr>
<tr><td><b>Perc P Time intervallo di date:</b> </td><td>{{ number_format($record->perc_p_time_daterange * 100, 2) }} % </td></tr>
{{--
<tr><td><b>Qualifica:</b></td><td> {{ $record->codqua }}] {{ $record->codqua_txt }} </td></tr>
<tr><td><b>Disciplina:</b> </td><td>{{ $record->disci1 }}]{{ $record->disci1_txt }} </td></tr>
--}}
</table>
{{--
<x-filament::input.checkbox wire:model="isAdmin" />
--}}
  {{ $this->form }}


<table class="table-auto">
    <thead>
        <tr> 
            <th>Descrizione</th> 
            <th>Punti</th>
        </tr>
    </thead>
    <tbody>
        <pre>
        {{-- print_r($form_data) --}}
        </pre>
        @foreach($form_data['ratings'] as $k=>$rating)
        <tr style="{{ $loop->index%2==0?'background:#eee':''}}">
            <td>
                {!! $rating['txt'] ?? $rating['title'] ?? 'WIP' !!}
            </td>
            <td align="right">
                
                @php
                    $rating_id=$rating['id'] ?? $k;
                    $fieldname='ratings.'.$rating_id.'.pivot.value';
                    if(!isset($rating['is_readonly'])) {
                        $rating['is_readonly']=false;
                    }
                @endphp
                {{-- $fieldname --}}
                {{--  
                <input type="number" step="1" 
                    class="form-control" wire:model.live="form_data.{{$fieldname}}" {{ $rating['is_readonly']?'readonly':'' }} 
                    style="{{ $rating['is_readonly']?'background-color:#eee':'' }}"
                    />
                --}}
                @if ($rating['is_readonly'])
                <x-filament::input.wrapper>
                <x-filament::input
                    type="text"
                    wire:model.live="form_data.ratings.{{ $k }}.pivot.value"
                    style="text-align:right;{{ $rating['is_readonly']?'background-color:#eee':'' }}"
                    readonly
                />
                </x-filament::input.wrapper>
                @else
                <x-filament::input.wrapper>
                <x-filament::input
                    type="number"
                    step="1" 
                    wire:model.live="form_data.ratings.{{ $k }}.pivot.value"
                    style="text-align:right;{{ $rating['is_readonly']?'background-color:#eee':'' }}"
                />
                </x-filament::input.wrapper>
                @endif                
            </td>
        </tr>
        @endforeach
        


    </tbody>
    <tfoot>
    {{--
    <tr>
        <td colspan="1" align="right"><b>Tot</b></td>
        <td align="right"><b>{{ $form_data['tot_gg'] }}</b></td>
        <td></td>
        <td align="right"><b>@money($form_data['tot_euro'],'EUR')</b></td>
    </tr>
    --}}
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
<table>
    <tr>
        <td>
            <x-filament::button type="button" wire:click="back()"> 
                <x-heroicon-o-arrow-uturn-left /> Back 
            </x-filament::button>
        </td>
        <td>
            <x-filament::button type="button" form="authenticate" wire:click="save()">
                <x-heroicon-o-arrow-up-circle />Salva
            </x-filament::button>
        </td>
    </tr>
</table>
<h3 class="fi-header-heading text-2xl ">{!! $record->msg('legenda') !!}</h3>

</x-filament::page>