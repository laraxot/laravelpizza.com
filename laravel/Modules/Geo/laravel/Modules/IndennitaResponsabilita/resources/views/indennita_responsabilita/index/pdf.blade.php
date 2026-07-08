@include('ptv::pdf.css01')
<page>
    {{--
    @include('ptv::pdf.intestazione')
    --}}
    <img src="{{ base_path('Modules/Ptv/resources/img/Logo-Provincia-orizzontale-neg.png') }}" style="height:50px" />
    <h3> @if(isset($rows[0])) {{ $rows[0]->valutatore?->nome_stabi }} <br/> @endif {{ $title }}</h3>
    <br/><br/>
    <table>
        <colgroup>
            <col style="width: 5%" class="col1">
            <col style="width: 10%">
            <col style="width: 85%">
        </colgroup>
        <thead>
        <tr>
            <th>Matr</th>
            <th>Cognome Nome</th>
            
            <th>dettaglio</th>
        </tr>
        </thead>
        <tbody>
    @foreach($rows as $row)
        <tr class="{{ $loop->index %2 ==0?'light':''}}">
            <td style="border-bottom: solid 1px #ababab;">
                {{ $row->matr }}
            </td>
            <td style="border-bottom: solid 1px #ababab;">
                {{ $row->cognome }}<br/>{{ $row->nome }} 
            </td>
            <td style="border-bottom: solid 1px #ababab;">
                <table >
                    <colgroup>
                        <col style="width: 55%" class="col1">
                        <col style="width: 15%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                    </colgroup>
                    
                    @foreach($row->ratings as $rating)
                        <tr>
                            <td> {{$rating->title}} </td>
                            <td  align="right">
                             @if(Str::contains($rating->txt, 'Importo'))
                                <b>@money($rating->pivot->value * 100,'EUR')</b>
                            @else
                                <b>{{ $rating->pivot->value }}</b>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                    

                </table>
                <br/>
                <b>{{  $row->note }}</b>
            </td>
           
        </tr>
    @endforeach
    </tbody>
    </table>
    
    @include('ptv::pdf.firma',['firma' => $row->valutatore?->nome_diri])
    
</page>