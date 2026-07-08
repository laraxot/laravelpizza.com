nds('adm_theme::layouts.app')
@section('content')
    <x-filament::badge> flash-message </x-filament::badge>
    @php
    //dddx($row);
    $scheda_criteri = $row->schedaCriteri;

    @endphp
    @include($view.'.head',['row'=>$row])

    @php
    //dddx(url()->previous());
    @endphp

    @includeWhen($row->righeDoppie,$view.'.righe_doppie',['rows'=>$row->righeDoppie])

    {{-- {!! Form::bsOpen($row,'update') !!} --}}
    {!! Form::model($row, ['url' => Request::fullUrl()]) !!}
    @method('put')


    <h3>Criteri di Valutazione</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Descr</th>
                <th>Peso</th>
                <th>Punteggio</th>
                {{-- <th>Punteggio Convertito</th> --}}
                <th>Punteggio Finale</th>
            </tr>
        </thead>
        @php
            $tot = 0;
        @endphp
        @foreach ($scheda_criteri as $k => $v)
            @php
                /*
                $max10=$row->rapportatoMax10Valutatore($v->field_name);
                $max10=round($max10,3);
                $max10Peso=$max10*$v->peso/10;
                $tot+=$max10Peso;
                */
                $converted = $row->convertedIn($v->field_name, $v->converted_in);
                $converted_peso = ($converted * $v->peso) / 10;
                $tot += $converted_peso;

            @endphp
            <tr>
                <td>{{ $v->descr }}</td>
                <td align="right">{{ round($v->peso, 2) }}</td>
                <td align="right">
                    @if ($v->is_editable)
                        {{ Form::bsText($v->field_name) }}
                    @else
                        {{ round($row->{$v->field_name}, 2) }}
                    @endif
                </td>
                {{-- <td align="right">
			{{ number_format($converted,3) }}
		</td> --}}
                <td align="right">
                    {{-- number_format($max10Peso,3) --}}
                    {{ number_format($converted_peso, 3) }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3">Punteggio Totale</td>
            <td align="right"><b>{{ number_format($tot, 3) }}</b>
                <input type="hidden" name="punt_progressione_finale" value="{{ round($tot, 3) }}" readonly="readonly">
            </td>
        </tr>
        <tr>
            <td colspan="1">
                {{ Form::bsText('email') }}
            </td>
            <td colspan="3">
                {{ Form::bsCheckboxSiNo('benificiario_progressione') }}
            </td>
        </tr>

        <tr>
            <td colspan="4" align="center">
                {{ Form::bsSubmit('Salva') }}
            </td>
        </tr>
    </table>
    {{ Form::close() }}


@endsection
