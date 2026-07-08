ude('ptv::pdf.css02')
<page backtop="20mm">
    <page_header>
        @include('ptv::intestazione')
    </page_header>

    @php
        //dddx($row->schedaCriteri);
       
        $msg = $row->messages->keyBy('type');
        //dddx($row->valutatore);
        //dddx($msg);
        $stabi_diri = $row->stabiDirigente;
        if (is_object($stabi_diri)) {
            $nome_stabi = $stabi_diri->nome_stabi;
        } else {
            $nome_stabi = 'Da settare in SatbiDirigente';
        }
    @endphp

    <h3>
        {!! nl2br($msg['scheda_valutazione_su']->txt) !!}
        <br/><br/>

        {{-- $row->valutatore->nome_stabi --}}
        {{ $nome_stabi }}
    </h3>
    @include($view.'.head')
    <br />
    <table class="table morpion" style="width:100%;">
        <col style="width: 60%;" />
        <col style="width: 20%;" />
        <col style="width: 20%;" />
        <thead>
            <tr>
                <th>
                    Criteri di Valutazione
                </th>
                <th>
                    Peso attribuito ai criteri di valutazione
                </th>
                <th>
                    Punteggio
                </th>
            </tr>
        </thead>
        @foreach ($row->schedaCriteri as $k => $v)
            <tr>
                <td>
                    {!! $v->descr !!}
                </td>
                <td align="right">
                    {{ $v->peso }}
                </td>
                <td align="right">
                    {{ number_format(($row->convertedIn($v->field_name, $v->converted_in) * $v->peso) / 10, 2) }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2">Totale</td>
            <td align="right">{{ number_format($row->punt_progressione_finale, 2) }}</td>
        </tr>
    </table>
    <br />
   
    <page_footer>
        @include($view.'.foot')
    </page_footer>
</page>
