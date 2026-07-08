@include('ptv::pdf.css')
<page>
    @include('ptv::pdf.intestazione')
    
    @php
        $row=$rows[0];
        $criteri = $row->criteriValutazione
        ->where('post_type',$row->type)
        ->sortBy('posizione');
    @endphp
    <h4 style="text-align:center;">SISTEMA DI MISURAZIONE E VALUTAZIONE DELLA PERFORMANCE INDIVIDUALE -
        Anno {{ $row->anno }}
        <br />
        {!! $row->option('titolo') !!}
    </h4>
    
    <table class="morpion" style="width:100%;">
        <col style="width: 4%;" />
        <col style="width: 22%" />
        <col style="width: 7%;" />
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
                <td>categoria</td>
                @foreach ($criteri as $criterio)
                    <td>{{ $criterio->label }}</td>
                @endforeach
                <td><b>Totale Punteggio</b></td>
                <td><b>Eccellente</b></td>
            </tr>
        </thead>
        @foreach ($rows->where('ha_diritto', 1)->where('totale_punteggio','>',0) as $row)
            <tr>
                <td>{{ $row->matr }}<br />[{{ $row->id }}]</td>
                <td>{{ $row->cognome }} {{ $row->nome }}<br /> {{ $row->email }}]</td>
                <td>{{ $row->categoria_ecoval }}</td>
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
    {{-- @if ($row->updated_at != '')
        {{ $row->updated_at->format('d/m/Y') }}
    @else
        {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    @endif --}}
    {{ \Carbon\Carbon::now()->format('d/m/Y') }}
</page>
