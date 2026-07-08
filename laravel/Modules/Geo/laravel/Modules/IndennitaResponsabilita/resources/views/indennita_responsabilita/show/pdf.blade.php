@include('ptv::pdf.css01')
<page>
   
    <img src="{{ base_path('Modules/Ptv/resources/img/Logo-Provincia-orizzontale-neg.png') }}" style="height:50px" />
    <table>
        <tr>
            <td>
                <h3>Indennita Responsabilita anno {{ $row->anno }}</h3>
            </td>
            <td>{{ $row->note }}</td>
        </tr>
    </table>
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
    
        <tr >
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
                            <td> {!! $rating->txt !!} </td>
                            <td  align="right"><b>{{ $rating->pivot->value }}</b></td>
                        </tr>
                    @endforeach
                    

                </table>
            </td>
           
        </tr>
    
    </tbody>
    </table>
    
    @include('ptv::pdf.firma')
    
</page>