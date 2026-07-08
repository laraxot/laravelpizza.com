e type="text/css">
    <!--
    div.zone {
        border: solid 2mm #66AACC;
        border-radius: 3mm;
        padding: 1mm;
        background-color: #FFEEEE;
        color: #440000;
    }

    div.zone_over {
        width: 30mm;
        height: 35mm;
        overflow: hidden;
    }

    table {
        border-top: 1px solid darkgray;
        border-left: 1px solid darkgray;
        width: 100%;

    }

    table.firma {
        border-top: 0px;
        border-left: 0px;
    }

    table.firma tr td {
        border-right: 0px;
        border-bottom: 0px;
    }

    th {
        text-align: center;
        border: solid 1px #113300;
        background: #EEFFEE;
    }

    td {
        text-align: left;
        border-right: solid 1px darkgray;
        border-bottom: solid 1px darkgray;
    }

    td.col1 {
        border-right: solid 1px darkblue;
        border-bottom: solid 1px darkblue;
        text-align: right;
    }

    end_last_page div {
        border: solid 1mm red;
        height: 27mm;
        margin: 0;
        padding: 0;
        text-align: center;
        font-weight: bold;
    }

    -->
</style>
<page style="font-size: 10pt" backtop="20mm" backbottom="10mm" backleft="5mm" backright="5mm">
    <page_header>
        @include('ptv::intestazione')

    </page_header>
    @include($view.'.head',['row'=>$row])
    {{-- <h3> Stabi-Repar : {{ $params['stabi'] }}-{{ $params['repar'] }} <br/>Anno : {{ $params['anno'] }}</h3> --}}
    {{-- $rows->count() --}}
    <table>
        {{-- <col style="width: 5%" class="col1"> --}}
        <col style="width: 11%">
        <col style="width: 9%">
        <col style="width: 8%">
        <col style="width: 29%">
        <col style="width: 7%">
        <col style="width: 7%">
        <col style="width: 7%">
        <col style="width: 7%">
        <col style="width: 7%">
        <col style="width: 7%">

        <tr>
            <td>[<b style="color:navy">ID</b>] <br /> Dipendente</td>
            <td>Categoria</td>
            <td>dal<br />al</td>
            <td>Posizione Lavoro</td>
            <td>complessita</td>
            <td>coord.</td>
            <td>resp.</td>
            <td>tot</td>
            <td>valore economico calcolato</td>
            <td>valore economico attribuito</td>
        </tr>
        @foreach ($rows->get() as $row)
            {{-- <tr @if ($row->tot > 0) style="background-color: lightgreen;" @endif>
			@if ($row->tot > 0) --}}
            <tr>
                <td>[<b style="color:navy">{{ $row->id }}</b>] <br />
                    {{ $row->ente }}-{{ $row->matr }}<br />
                    {{ $row->cognome }} {{ $row->nome }}
                </td>
                <td><small>{{ $row->propro }}-{{ $row->posfun }}</small><br />
                    {{ str_replace('Posizione economica', '', $row->categoria_eco) }}
                </td>
                <td>{{ $row->dalf->format('d/m/Y') }} <br />
                    {{ $row->alf->format('d/m/Y') }}
                </td>
                <td align="left">{{ $row->posizione_lavoro }}</td>
                <td align="right">{{ $row->complessita }}</td>
                <td align="right">{{ $row->coordinamento }}</td>
                <td align="right">{{ $row->responsabilita }}</td>
                <td align="right">{{ $row->tot }}</td>
                <td align="right">{{ $row->valore_economico_calcolato }}</td>
                <td align="right">{{ $row->valore_economico_attribuito }}</td>
            </tr>
            {{-- @endif --}}
        @endforeach
    </table>

    @include($view.'.firma',['row'=>$row])

</page>
