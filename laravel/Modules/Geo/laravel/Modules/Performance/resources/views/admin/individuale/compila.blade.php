nds('adm_theme::layouts.app')
@section('page_heading', 'Modifica Valutazione')

@section('section')
    <x-filament::badge> flash-message </x-filament::badge>
    @php
    /*
            if (!$row->ha_diritto && $row->posfun < 100) {
                echo '<h3>UTENTE CHE NON HA DIRITTO</h3>';
                return;
            }
            */
    @endphp


    @if ($row->cards->count() > 1)
        <h3 style="color:darkred">
            Lavoratore che ha cambiato settore o categoria
        </h3>
        <table class="table table bordered">
            @foreach ($row->cards as $card)
                <tr>
                    <td>{{ $card->id }} </td>
                    <td>{{ $card->stabi }} {{ $card->stabi_txt }}<br />
                        {{ $card->repar }} {{ $card->repar_txt }}
                    </td>
                    <td>{{ $card->propro }}-{{ $card->posfun }}<br />
                        {{ $card->posizione_eco }}
                    </td>
                    <td>{{ $card->dal }}</td>
                    <td>{{ $card->al }}</td>
                </tr>
            @endforeach
        </table>
        @php
            $last_card = $row->cards->sortBy('dal')->last();
        @endphp
        @if ($last_card->id != $row->id)
            <h1 style="color:darkred">
                Utente valutato da altro settore
                [{{ $last_card->stabi }}) {{ $last_card->stabi_txt }} -
                {{ $last_card->repar }}) {{ $last_card->repar_txt }}]
            </h1>
        @endif
    @endif
    @push('styles')
        <style>
            label {
                display: none;
            }

            input {
                width: 5em;
            }

            input[type=text] {
                width: 5em;
            }

        </style>
    @endpush
    {{-- {!! Form::bsBtnBack('edit') !!} --}}
    <a href="{{ Panel::make()->get($row)->url('index') }}" class="btn btn-primary">&laquo; Torna alla lista </a>
    <h3 style="text-align:center;">
        SISTEMA DI MISURAZIONE E VALUTAZIONE DELLA PERFORMANCE INDIVIDUALE <br /> Anno {{ $row->anno }}
    </h3>
    @php
    //dddx($row->options);
    @endphp

    <h4>{!! $row->option('titolo') !!}</h4>
    {{-- <h4>Scheda di valutazione del PERSONALE NON DIRIGENZIALE </h4> --}}
    <br />
    {{-- {!! Form::bsOpen($row,'update') !!} --}}
    {!! Form::model($row, ['url' => Request::fullUrl()]) !!}
    @method('put')
    <b>Dipendente:</b> {{ $row->cognome }} {{ $row->nome }} <b>matr:</b> {{ $row->matr }} <b>Cat. Giur:</b>
    {{ $row->posizione_eco }} <br />
    <b>Settore:</b> {{ $row->stabi_txt }} <b>Reparto:</b> {{ $row->repar_txt }}
    {{-- <br/>codqua: {{ $row->codqua }}
    <br/>cont: {{ $row->cont }}
    <br/>tipco: {{ $row->tipco }} --}}
    <br />
    <b>dal:</b> {{ $row->dal }} <b>al:</b> {{ $row->al }}
    {{-- <b>Inizio :</b>{$FormData.dalr.html}<br style="clear:both"/> <b>Fine:</b>{$FormData.alr.html} --}}
    <br /><b>email</b>{{ Form::bsEmail('email', null, ['style' => 'width:30em']) }}
    {{-- <br/><b>Note</b>{{ Form::bsTextarea('note') }}
    <br/><br/><br/> --}}
    <br style="clear:both" />

    @php
    //$criteri = $row->options->where('name', 'criterio')->where('parent_id', 0);
     $criteri = $row->optionsCriteriOrdered();
    @endphp

    <table class="table table-bordered">
        <tr>
            <th>Comportamento<br /> atteso dalla persona</th>
            <th>Descrittori di giudizio / Punti Valore del descrittore di giudizio</th>
            <th>Peso del comportamento</th>
            <th>Punti attribuiti alla persona</th>
            <th>Punteggio finale</th>
        </tr>
        @foreach ($criteri as $criterio)
            <tr>

                <td>{!! $criterio->txt !!}</td>
                <td style="padding:0;margin:0;">
                    <table>
                        @foreach ($criterio->sons as $son)
                            <tr>
                                <td>{{ $son->txt }}</td>
                                <td nowrap>{{ $son->txt1 }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                @php
                    $name = $criterio->value;
                    $pk = 'peso_' . $name;
                @endphp
                <td>
                    <div id="{{ $pk }}">{{ $row->$pk }}</div>
                </td>
                <td>{{ Form::bsText($name, null, ['label' => ' ']) }}</td>
                <td>
                    <div id="tot_{{ $name }}"></div>
                </td>
            </tr>

        @endforeach
        <tr>
            <th colspan="4">Totale punteggio attribuito</th>
            <th>
                <div id="tot">...</div>
                <div style="display:none;">
                    {{ Form::bsText('totale_punteggio') }}
                </div>
            </th>
        </tr>
        <tr>
            <th colspan="2">Eccellente</th>
            <th colspan="3">
                {{ Form::bsCheckboxSiNo('excellence') }}
            </th>
        </tr>
        <tr>
            <td colspan="5" align="center">
                {{ Form::submit('Salva ed esci', ['class' => 'submit btn btn-success green-meadow']) }}
            </td>
        </tr>
    </table>
    {!! Form::close() !!}

@endsection

@push('scripts')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        function aggiornaTot() {
            var tot = 0;

            var fieldz = new Array("risultati_ottenuti", "qualita_prestazione", "arricchimento_professionale", "impegno",
                "esperienza_acquisita");
            for (i in fieldz) {
                k = fieldz[i];
                //alert(k);
                v = $("input[name='" + k + "']").val();
                v = parseFloat(v);
                p = $('#peso_' + k + '').html();
                p = parseInt(p);
                t = v * p / 4;
                $('#tot_' + k + '').html(t.toFixed(2));
                tot += t;
            }

            $('#tot').html(tot.toFixed(2));
            $("input[name='totale_punteggio']").val(tot.toFixed(2));
            //$( "input[name='tot']").val(tot);


        }


        $("input:text").on("keyup", function(e) {
            //alert('pippo');
            //alert($(this).val());
            aggiornaTot();
        });
        aggiornaTot();
    </script>
@endpush
