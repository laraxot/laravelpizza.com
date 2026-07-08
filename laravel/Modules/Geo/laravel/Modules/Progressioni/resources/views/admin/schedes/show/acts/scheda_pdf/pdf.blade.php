e type="text/css">
    table.morpion {
        border-right: solid 1px #444444;
    }

    table.morpion tr {
        border-bottom: solid 1px #000000;
    }

    table.morpion td {
        border-left: solid 1px #000000;
        border-bottom: solid 1px #000000;
        text-align: left;
        valign: top;
        font-size: 10pt;
        padding: 4px;
        /*height:12px;
 */
        padding: 2px;
    }

    table.morpion th {
        border-top: solid 1px #000000;
        border-left: solid 1px #000000;
        border-bottom: solid 1px #000000;
        text-align: center;
        valign: top;
        font-size: 11pt;
        height: 40px;
        padding: 4px;
    }

    td.verticale {
        writing-mode: tb-rl;
        filter: flipv fliph;
    }

    .alt {
        background-color: #C0F0C0;
    }

    .rot {
        rotate: 90;
        text-align: center;
        height: 100%;
        width: 100%;
        padding: 0px;

    }

    .thead {
        width: 30px;
        text-align: center;
        vertical-align: middle;

    }

</style>
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
                    {{ $v->descr }}
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
    {{-- {{ $msg['scheda_valutazione_giu']->txt }} --}}
    <page_footer>
        @include($view.'.food')
    </page_footer>
</page>
