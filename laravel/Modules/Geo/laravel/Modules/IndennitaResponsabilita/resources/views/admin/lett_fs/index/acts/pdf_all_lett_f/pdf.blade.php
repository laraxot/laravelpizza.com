ude('theme::includes.pdf.css')
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
        <col style="width: 28%">
        <col style="width: 6%">
        <col style="width: 6%">
        <col style="width: 6%">
        <col style="width: 6%">
        <col style="width: 6%">
        <col style="width: 6%">
        <col style="width: 6%">

        <tr>
            <td>[<b style="color:navy">ID</b>] <br /> Dipendente</td>
            <td>Categoria</td>
            <td>dal<br />al</td>
            <td>Posizione Lavoro</td>
            <td>compl.</td>
            <td>coord.</td>
            <td>resp.</td>
            <td>tot</td>
            <td>valore econ. calcolato</td>
            <td>valore econ. attribuito</td>
            <td>valore econ. effettivo</td>
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
                <td align="right">{{ $row->valore_economico_effettivo }}</td>
            </tr>
            {{-- @endif --}}
        @endforeach
    </table>

    @include($view.'.firma',['row'=>$row])

</page>
