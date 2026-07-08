nds('adm_theme::layouts.app')
@section('page_heading', 'Modifica Resposabilita Lett F')

@section('content')
    <x-filament::badge> flash-message </x-filament::badge>

    <style>
        table label {
            display: none;
        }

        table input[type='text'] {
            width: 100px;
            text-align: right;
        }

    </style>
    {{-- {!! Form::bsBtnBack('edit') !!} --}}
    <a href="{{ Panel::make()->get($row)->url('index') }}" class="btn btn-primary">&laquo; Torna alla lista </a>
    {!! Form::bsOpen($row, 'update') !!}

    <h3 style="text-align:center;">
        Scheda di attribuzione indennità di responsabilità (art.17, comma 2, lett.f) ccnl 1.4.1999 - Anno
        {{ $row->anno }}
    </h3>
    <br />

    <b>Dipendente:</b> {{ $row->cognome }} {{ $row->nome }} <b>matr:</b> {{ $row->matr }} <b>Cat. Giur:</b>
    {{ $row->categoria_eco }} <br />
    <b>Posizione di Lavoro:</b>{{ Form::bsTextarea('posizione_lavoro') }}<br />
    <br style="clear:both" />
    @php
    //dddx(get_class($row));
    @endphp
    <b>Settore:</b> {{ $row->stabi_txt }} <b>Reparto:</b> {{ $row->repar_txt }}
    {{-- <br/>{{ Form::bsDateRange('dalf','alf') }} --}}
    <div class="row">
        <div class="col-md-3">
            {{ Form::bsDate('dalf') }}
        </div>
        <div class="col-md-3">
            {{ Form::bsDate('alf') }}
        </div>
    </div>
    {{ Form::bsText('email') }}<br /><br />
    <br style="clear:both" />

    <table class="table table-striped table-bordered">

        <tr>
            <th>Fattore di valutazione</th>
            <th>Descrittori di valutazione</th>
            <th>Punteggio massimo attribuibile</th>
            <th>Punteggio attrivuito dal dirigente</th>
        </tr>
        <tr>
            <td rowspan="3">Grado di complessità degli incarichi in relazione al livello di responsabilità</td>
            <td>Responsabilità collegate ad attività per la realizzazione delle quali è necessario gestire procedimenti
                <b>particolarmente complessi e non ripetitivi.</b> La particolare complessità si misura in relazione al
                livello di discrezionalità amministrativa o tecnica rimessa in capo al dipendente
            </td>
            <td>Sino a 40</td>
            <td rowspan="3">{{ Form::bsText('complessita') }}</td>
        </tr>
        <tr>
            <td>Responsabilità collegate ad attività per la realizzazione delle quali è necessario gestire <b>procedimenti
                    complessi anche se ripetitivi.</b> La complessità si misura in relazione al livello di discezionalità
                amministrativa o tecnica rimessa in capo al dipendente</td>
            <td>Sino a 25</td>
        </tr>
        <tr>
            <td>Responsabilità collegate ad attività per la realizzzazione delle quali è necessario gestire <b>procedimenti
                    non qualificati da complessità</b> amministrativa o tecnica, di <b>carattere ripetitivo e
                    standardizzato</b></td>
            <td>Sino a 15</td>
        </tr>
        <tr>
            <td rowspan="3">Livello di coordinamento e autonomia</td>
            <td>Gestione procedimenti con <b>elevata autonomia</b> operativa in attività prevalentemente diversa e non
                definibile con <b>funzione di coordinamento</b></td>
            <td>Sino a 30</td>
            <td rowspan="3">{{ Form::bsText('coordinamento') }}</td>
        </tr>
        <tr>
            <td>Gestione di procedimenti secondo <b>programmi operativi definiti</b> e secondo una prassi consolidata</td>
            <td>Sino a 20</td>
        </tr>
        <tr>
            <td>Gestione di procedimenti con <b>modesta autornomia operativa</b> in attività standardizzata</td>
            <td>Sino a 10</td>
        </tr>
        <tr>
            <td rowspan="3">Grado di responsabilità verso l'interno e/o l'esterno</td>
            <td>Gestione procedimenti che comportano un esclusivo rilievo esterno, trattandosi di incarichi volti ad
                assolvere adempimenti previsti da leggi o regolamenti. Tali incarichi denotano anche relazioni e rapporti
                interorganici (istituzioni, enti, organi giurisdizionali, organi di massimo veritce politico, ecc)</td>
            <td>Sino a 30</td>
            <td rowspan="3">{{ Form::bsText('responsabilita') }}</td>
        </tr>
        <tr>
            <td>Gestione procedimenti che comportano anche un rilievo esterno di supporto ad attività assegnate ai
                responsabili della struttura di appartenenza</td>
            <td>Sino a 20</td>
        </tr>
        <tr>
            <td>Gestione procedimenti che comportano esclusivamente un rilievo interno all'Ente o alla struttura
                organizzativa di appartenenza</td>
            <td>Sino a 10</td>
        </tr>
        <tr>
            <th colspan="3">Totale punteggio attribuito</th>
            <th>
                <div id="tot" align="right">...</div>
            </th>
        </tr>
        <tr>
            <td colspan="3" align="center">Valore Economico Calcolato</td>
            <td align="right">
                <div id="valEco" align="right">...</div>
            </td>
        </tr>
        <tr>
            <th colspan="3" style="font-size:20pt;">Valore Economico Attribuito (1)</th>
            <th>
                <div id="valEcoAttr" style="font-size:20pt;text-align: right;">...</div>
            </th>
        </tr>
        <tr>
            <td colspan="4" align="center">{{ Form::bsSubmit('salva') }}</td>
        </tr>

    </table>
    <div style="display:none">
        {{ Form::bsText('tot') }}
        {{ Form::bsText('valore_economico_calcolato') }}
        {{ Form::bsText('valore_economico_attribuito') }}
    </div>
    {{ Form::close() }}


    (1) clausola di salvaguardia Art.24 comma 3 cci
    <br /> gli importi non possono essere inferiori ai seguenti valori

    <table border="1">
        <tr>
            <th>Categoria</th>
            <th>Importo Minimo</th>
            <th>Importo Massimo</th>
        </tr>
        <tr>
            <td align="center">{{ $row->importi->categoria }}</td>
            <td align="right">{{ $row->importi->min }} </td>
            <td align="right">{{ $row->importi->max }} </td>
        </tr>
    </table>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script>
        function aggiornaTot() {
            var elements = $("input:text");
            var tot = 0;
            /*
            for(var i = 0; i< elements.length; i++){
            v=$(elements[i]).val();
            v=parseInt(v);
            tot= tot + v;
            }*/
            v = $("input[name='complessita']").val();
            v = parseInt(v);
            tot = tot + v;
            //----------
            v = $("input[name='coordinamento']").val();
            v = parseInt(v);
            tot = tot + v;
            //----------
            v = $("input[name='responsabilita']").val();
            v = parseInt(v);
            tot = tot + v;
            //----------


            $('#tot').html(tot);
            $("input[name='tot']").val(tot);

            //var eco=tot*{$importi->max}/100;
            var $importo_min = {{ $row->importi->min }}; //{$importi->min}
            var $importo_max = {{ $row->importi->max }}; //{$importi->max}
            var eco = tot * $importo_max / 100;
            $('#valEco').html(eco);
            $("input[name='valore_economico_calcolato']").val(eco);
            var ecoAttr = 0;
            if (eco < $importo_min) {
                ecoAttr = $importo_min;
            } else {
                ecoAttr = eco;
            }
            $('#valEcoAttr').html(ecoAttr);
            $("input[name='valore_economico_attribuito']").val(ecoAttr);
            //alert(tot);
        }


        $("input:text").on("keyup", function(e) {
            //alert($(this).val());
            aggiornaTot();
        });
        aggiornaTot();
    </script>


    <br style="clear:both" />
    <br style="clear:both" />
    <br style="clear:both" />
    <br style="clear:both" />
    <br style="clear:both" />

@endsection
