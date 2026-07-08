e type="text/css">
    body {
        font-size: 6pt;
    }

    table.morpion {
        border: solid 1px #444444;
    }

    table.morpion td {
        border-left: solid 1px #000000;
        border-bottom: solid 1px #000000;
        text-align: left;
        valign: top;
        font-size: 6.3pt;
        height: 12px;
        padding: 1px;
    }

    table.morpion th {
        border-left: solid 1px #000000;
        border-bottom: solid 1px #000000;
        text-align: left;
        valign: top;
        font-size: 7pt;
        height: 40px;
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
<page>
    @include('ptv::intestazione')
    @php
        $criteri = $row->criteriValutazione->sortBy('posizione');
    @endphp
    <h4 style="text-align:center;">SISTEMA DI MISURAZIONE E VALUTAZIONE DELLA PERFORMANCE INDIVIDUALE -
        Anno{{ $row->anno }}
        <br />
        {!! $row->option('titolo') !!}
    </h4>
    <table class="morpion" style="width:100%;">
        <col style="width: 5%;" />
        <col style="width: 20%" />
        <col style="width: 20%;" />
        <col style="width: 7%;text-align:right;" />
        <col style="width: 7%;text-align:right;" />
        <col style="width: 7%;text-align:right;" />
        <col style="width: 7%;text-align:right;" />
        <col style="width: 7%;text-align:right;" />
        <col style="width: 7%;text-align:right;" />
        <col style="width: 7%;text-align:center;" />

        <thead>
            <tr>
                <td>matr</td>
                <td>lavoratore</td>
                <td>categoria eco</td>
                @foreach ($criteri as $criterio)
                    <td>{{ $criterio->label }}</td>
                @endforeach
                <td><b>Totale Punteggio</b></td>
                <td><b>Eccellente</b></td>
            </tr>
        </thead>
        @foreach ($rows->get() as $row)
            <tr>
                <td>{{ $row->matr }}<br />[{{ $row->id }}]</td>
                <td>{{ $row->cognome }} {{ $row->nome }}<br /> {{ $row->email }}]</td>
                <td>{{ $row->posizione_eco }}</td>
                @foreach ($criteri as $criterio)
                    <td>{{ $row->{$criterio->nome} }}</td>
                @endforeach
                <td>{{ $row->totale_punteggio }}</td>
                <td>
                    @if ($row->excellence)<b style="darkred">SI</b>@endif
                </td>
            </tr>
        @endforeach
    </table>
    <br />IL DIRIGENTE
    <br /><span style="font-size:14px">{{ $row->stabiDirigente->nome_diri }}</span>
    <br /><br />Treviso, li
    @if ($row->updated_at != '')
        {{ $row->updated_at->format('d/m/Y') }}
    @else
        {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    @endif
</page>
