e type="text/css">
    <!--
    table.morpion {
        border: solid 1px #000000;
        width: 90%;
    }
    }

    table.morpion th {
        font-size: 8pt;
        font-weight: bold;
        border-left: solid 1px #000000;
        border-bottom: solid 1px #000000;
        padding: 1px;
        text-align: center;
    }
    }



    table.morpion td {
        font-size: 8pt;
        border: solid 1px #000000;
        border-left: solid 1px #000000;
        border-bottom: solid 1px #000000;
        text-align: center;
    }
    }

    table.morpion td.j1 {
        color: #0A0;
    }
    }

    table.morpion td.j2 {
        color: #A00;
    }
    }

    .alt {
        background-color: #C0F0C0;
    }
    }

    -->
</style>
<page backtop="20mm" backbottom="10mm" backleft="5mm" backright="5mm">
    <page_header>
        @include('ptv::intestazione')
    </page_header>
    {{-- <img src="{{ Theme::img_src('ptv::img/logo_ptv70px.gif') }}" alt="" style="height:70px;" height="70px"> --}}
    @php
        $msg = $row->messages->keyBy('type');
    @endphp
    <h3 style="text-align:center;">
        {{-- {!! nl2br($msg['responsabilita_f_su']->txt) !!} --}}
        {!! $row->msg('responsabilita_f_su') !!}

    </h3>
    <br />
    <b>Dipendente:</b> {{ $row->cognome }} {{ $row->nome }} <b>matr:</b> {{ $row->matr }} <b>Cat. Giur:</b>
    {{ $row->categoria_eco }} <br />
    <b>Posizione di Lavoro:</b>{{ $row->posizione_lavoro }}<br />
    <b>Settore:</b> {{ $row->stabi_txt }} <b>Reparto:</b> {{ $row->repar_txt }}
    <br /><b>Dal: </b>{{ $row->dalf->format('d/m/Y') }} <b>Al: </b>{{ $row->alf->format('d/m/Y') }}
    <br /><br />
    <table class="morpion" align="center">

        <tr>
            <th style="width: 25%; text-align: left; ">Fattore di valutazione</th>
            <th style="width: 55%; text-align: left; ">Descrittori di valutazione</th>
            <th style="width: 10%; text-align: left; ">Punteggio<br /> massimo<br /> attribuibile</th>
            <th style="width: 10%; text-align: left; ">Punteggio<br /> attrivuito<br /> dal<br /> dirigente</th>
        </tr>
        <tr class="alt">
            <td rowspan="3" style="width: 25%;">Grado di complessit&aacute; degli incarichi in relazione al livello di
                responsabilit&aacute;</td>
            <td style="width: 55%;">Responsabilit&aacute; collegate ad attivit&aacute; per la realizzazione delle quali
                &eacute; necessario gestire procedimenti <b>particolarmente complessi e non ripetitivi.</b> La
                particolare complessit&aacute; si misura in relazione al livello di discrezionalit&aacute;
                amministrativa o tecnica rimessa in capo al dipendente</td>
            <td style="width: 10%;">Sino a 40</td>
            <td rowspan="3" style="width: 10%;" align="right">{{ $row->complessita }}</td>
        </tr>
        <tr class="alt">
            <td style="width: 55%;">Responsabilit&aacute; collegate ad attivit&aacute; per la realizzazione delle quali
                &eacute; necessario gestire <b>procedimenti complessi anche se ripetitivi.</b> La complessit&aacute; si
                misura in relazione al livello di discezionalit&aacute; amministrativa o tecnica rimessa in capo al
                dipendente</td>
            <td style="width: 10%;">Sino a 25</td>
        </tr>
        <tr class="alt">
            <td style="width: 55%;">Responsabilit&aacute; collegate ad attivit&aacute; per la realizzzazione delle quali
                &eacute; necessario gestire <b>procedimenti non qualificati da complessit&aacute;</b> amministrativa o
                tecnica, di <b>carattere ripetitivo e standardizzato</b></td>
            <td style="width: 10%;">Sino a 15</td>
        </tr>
        <tr>
            <td rowspan="3" style="width: 25%;">Livello di coordinamento e autonomia</td>
            <td style="width: 55%;">Gestione procedimenti con <b>elevata autonomia</b> operativa in attivit&aacute;
                prevalentemente diversa e non definibile con <b>funzione di coordinamento</b></td>
            <td style="width: 10%;">Sino a 30</td>
            <td rowspan="3" style="width: 10%;" align="right">{{ $row->coordinamento }}</td>
        </tr>
        <tr>
            <td style="width: 55%;">Gestione di procedimenti secondo <b>programmi operativi definiti</b> e secondo una
                prassi consolidata</td>
            <td style="width: 10%;">Sino a 20</td>
        </tr>
        <tr>
            <td style="width: 55%;">Gestione di procedimenti con <b>modesta autornomia operativa</b> in attivit&aacute;
                standardizzata</td>
            <td style="width: 10%;">Sino a 10</td>
        </tr>
        <tr class="alt">
            <td rowspan="3" style="width: 25%;">Grado di responsabilit&aacute; verso l'interno e/o l'esterno</td>
            <td style="width: 55%;">Gestione procedimenti che comportano un esclusivo rilievo esterno, trattandosi di
                incarichi volti ad assolvere adempimenti previsti da leggi o regolamenti. Tali incarichi denotano anche
                relazioni e rapporti interorganici (istituzioni, enti, organi giurisdizionali, organi di massimo veritce
                politico, ecc)</td>
            <td style="width: 10%;">Sino a 30</td>
            <td rowspan="3" style="width: 10%;" align="right">{{ $row->responsabilita }}</td>
        </tr>
        <tr class="alt">
            <td style="width: 55%;">Gestione procedimenti che comportano anche un rilievo esterno di supporto ad
                attivit&aacute; assegnate ai responsabili della struttura di appartenenza</td>
            <td style="width: 10%;">Sino a 20</td>
        </tr>

        <tr class="alt">
            <td style="width: 55%;">Gestione procedimenti che comportano esclusivamente un rilievo interno
                all&acute;Ente o alla struttura organizzativa di appartenenza</td>
            <td style="width: 10%;">Sino a 10</td>
        </tr>

        <tr>
            <th colspan="3">Totale punteggio attribuito</th>
            <th align="right">{{ $row->tot }}</th>
        </tr>

        <tr>
            <td colspan="3" align="center">Valore Economico Calcolato</td>
            <td align="right">{{ $row->valore_economico_calcolato }}</td>
        </tr>

        <tr>
            <th colspan="3" style="font-size:12pt;">Valore Economico Attribuito (1)</th>
            <th align="right">{{ $row->valore_economico_attribuito }}</th>
        </tr>


    </table>
    {{-- (1) clausola di salvaguardia Art.24 comma 3 cci
<br/> gli importi non possono essere inferiori ai seguenti valori --}}
    <p>
        {{-- {!! nl2br($msg['responsabilita_f_giu']->txt) !!} --}}
        {!! $row->msg('responsabilita_f_giu') !!}
    </p>

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

    <br /><br /><br />

    <table style="width:100%;">
        <tr>
            <td style="width:33%;font-size:12pt;">Data
                <br /> {{ $row->updated_at->format('d/m/Y') }}
            </td>
            <td style="width:66%;font-size:12pt;">IL DIRIGENTE DI SETTORE
                <br /><b>{{ $row->stabi_dirigente->nome_diri }}</b>
                <br />_____________________________
            </td>

        </tr>
    </table>
</page>
