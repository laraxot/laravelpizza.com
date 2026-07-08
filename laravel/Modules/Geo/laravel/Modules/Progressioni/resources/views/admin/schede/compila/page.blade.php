<x-filament::page>
    
   {{-- dddx($record->integParams) --}}

    <h3>Criteri di Valutazione</h3>
    <table class="table table-auto border-collapse border border-slate-400 ">
        <thead>
            <tr>
                <th class="border border-slate-300">Descrizione</th>
                <th class="border border-slate-300">Peso</th>
                <th class="border border-slate-300">Punteggio</th>
                {{-- <th>Punteggio Convertito</th> --}}
                <th class="border border-slate-300">Punteggio Finale</th>
            </tr>
        </thead>
        <tbody>
             @php
            $tot = 0;
        @endphp
        
        @foreach ($record->schedaCriteri as $k => $v)
            @php
                
                $converted = $record->convertedIn($v->field_name, $v->converted_in);
                $converted_peso = ($converted * $v->peso) / 10;
                $tot += $converted_peso;

            @endphp
            <tr>
                <td class="border border-slate-300">{!! $v->descr !!}</td>
                <td class="border border-slate-300" align="right">{{ round($v->peso, 2) }}</td>
                <td class="border border-slate-300" align="right">
                    @if ($v->is_editable)
                        {{-- Form::bsText($v->field_name) --}}
                        <x-filament::input.wrapper alpine-valid="! errors.includes('form_data.{{ $v->field_name }}')">
                            <x-filament::input
                                type="text"
                                wire:model="form_data.{{ $v->field_name }}"
                                :placeholder="$v->field_name"
                                style="text-align: right;"
                            />
                        </x-filament::input.wrapper>
                    @else
                        {{ round($record->{$v->field_name}, 2) }}
                    @endif
                </td>
                {{-- <td align="right">
			{{ number_format($converted,3) }}
		</td> --}}
                <td class="border border-slate-300" align="right">
                    {{-- number_format($max10Peso,3) --}}
                    {{ number_format($converted_peso, 3) }}
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Punteggio Totale</td>
                <td align="right"><b>{{ number_format($tot, 3) }}</b>
                    <input type="hidden" name="punt_progressione_finale" value="{{ round($tot, 3) }}" readonly="readonly">
                </td>
            </tr>
            <tr>
                <td colspan="1">
                    {{-- Form::bsText('email') --}}
                    <x-filament::input.wrapper>
                    <x-filament::input
                        type="text"
                        wire:model="form_data.email"
                        placeholder='email'
                    />
                    </x-filament::input.wrapper>

                </td>
                <td colspan="3">
                    {{-- 
                    <label>
                        <x-filament::input.checkbox wire:model="form_data.benificiario_progressione" />
                    
                        <span>
                            Benificiario Progressione
                        </span>
                    </label>
                    --}}
                </td>
            </tr>

            <tr>
                <td colspan="4" align="center">
                    @if ($errors->any())
                        <div class="text-danger-600 hover:text-danger-700">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- Form::bsSubmit('Salva') --}}
                    <x-filament::button type="button" wire:click="back()"> <x-heroicon-o-arrow-uturn-left /> Back </x-filament::button>
                    <x-filament::button type="button" form="authenticate" wire:click="save()">
                        <x-heroicon-o-arrow-up-circle />Salva
                    </x-filament::button>
                </td>
            </tr>
        </tfoot>
    </table>
    <pre>
        {{-- print_r($form_data,true) --}}
    </pre>
</x-filament::page>