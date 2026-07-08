    <h3 style="text-align:center;">
        Scheda di attribuzione indennità di responsabilità (art.17, comma 2, lett.f) ccnl 1.4.1999 - Anno
        {{ $form_data['anno'] }}
    </h3>
    <br />

    <b>Dipendente:</b> {{ $form_data['cognome'] }} {{ $form_data['nome'] }} <b>matr:</b> {{ $form_data['matr'] }} <b>Cat. Giur:</b>
    {{ $form_data['categoria_eco'] }} <br />
    <b>Posizione di Lavoro:</b>
        {{-- Form::bsTextarea('posizione_lavoro') --}}
        <x-filament::input type="textarea" name="posizione_lavoro" label="" />
    <br />
    <br style="clear:both" />
    @php
    //dddx(get_class($row));
    @endphp
    <b>Settore:</b> {{ $form_data['stabi_txt'] }} <b>Reparto:</b> {{ $form_data['repar_txt'] }}

    <div class="row">
        <div class="col-md-3">
            {{-- Form::bsDate('dalf') --}}
            {{-- $form_data['dalf'] --}}
            <x-filament::input type="date" name="dalf" label="" />
        </div>
        <div class="col-md-3">
            {{-- Form::bsDate('alf') --}}
            {{-- $form_data['alf'] --}}
            <x-filament::input type="date" name="alf" label="" />
        </div>
    </div>
    {{-- Form::bsText('email') --}}
    <x-filament::input type="email" name="email" label="email" />
    <br /><br />
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
            <td rowspan="3">
                {{-- Form::bsText('complessita') --}}
                <x-filament::input type="number" name="complessita" label="" />
            </td>
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
            <td rowspan="3">
                {{-- Form::bsText('coordinamento') --}}
                <x-filament::input type="number" name="coordinamento" label="" />
            </td>
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
            <td rowspan="3">Grado di responsabilità verso l&acute;interno e/o l&acute;esterno</td>
            <td>Gestione procedimenti che comportano un esclusivo rilievo esterno, trattandosi di incarichi volti ad
                assolvere adempimenti previsti da leggi o regolamenti. Tali incarichi denotano anche relazioni e rapporti
                interorganici (istituzioni, enti, organi giurisdizionali, organi di massimo veritce politico, ecc)</td>
            <td>Sino a 30</td>
            <td rowspan="3">
                {{-- Form::bsText('responsabilita') --}}
                <x-filament::input type="number" name="responsabilita" label="" />

            </td>
        </tr>
        <tr>
            <td>Gestione procedimenti che comportano anche un rilievo esterno di supporto ad attività assegnate ai
                responsabili della struttura di appartenenza</td>
            <td>Sino a 20</td>
        </tr>
        <tr>
            <td>Gestione procedimenti che comportano esclusivamente un rilievo interno all&acute;Ente o alla struttura
                organizzativa di appartenenza</td>
            <td>Sino a 10</td>
        </tr>
        <tr>
            <th colspan="3">Totale punteggio attribuito</th>
            <th>
                <div id="tot" align="right">{{ number_format($this->totalePunteggioAttribuito(),2) }}</div>
            </th>
        </tr>
        <tr>
            <td colspan="3" align="center">Valore Economico Calcolato</td>
            <td align="right">{{ number_format($this->valoreEconomicoCalcolato(),2) }}</td>
        </tr>
        <tr>
            <th colspan="3" style="font-size:20pt;">Valore Economico Attribuito (1)</th>
            <td align="right"><b>{{ number_format($this->valoreEconomicoAttribuito(),2) }}</b></td>
        </tr>
         <tr>
            <th colspan="3" style="font-size:20pt;">Valore Economico Effettivo (2)</th>
            <td align="right"><b>{{ number_format($this->valoreEconomicoEffettivo(),2) }}</b></td>
        </tr>
        <tr>
            <td colspan="4" align="center">
                {{-- Form::bsSubmit('salva') --}}
                <x-filament::badge> flash-message </x-filament::badge>
                <button type="button" wire:click="update()" class="btn btn-success">salva</button>
            </td>
        </tr>

    </table>



    (1) clausola di salvaguardia Art.24 comma 3 cci
    <br /> gli importi non possono essere inferiori ai seguenti valori

    <table border="1">
        <tr>
            <th>Categoria</th>
            <th>Importo Minimo</th>
            <th>Importo Massimo</th>
        </tr>
        <tr>
            <td align="center">{{ $form_data['importi_categoria'] }}</td>
            <td align="right">{{ $form_data['importi_min'] }} </td>
            <td align="right">{{ $form_data['importi_max'] }} </td>
        </tr>
    </table>

    (2) valore economico effettivo rispetto al periodo individuato

</div>
