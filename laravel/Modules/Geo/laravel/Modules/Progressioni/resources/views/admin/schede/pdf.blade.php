@include('ptv::pdf.css01')
<page>
    {{--
    @include('ptv::pdf.intestazione')
    --}}
    <img src="{{ base_path('Modules/Ptv/resources/img/Logo-Provincia-orizzontale-neg.png') }}" style="height:50px" />
    <h3>{{-- $title --}}</h3>
      <table>
        <colgroup>
            <col style="width: 5%" class="col1">
            <col style="width: 5%" class="col1">
            <col style="width: 10%;border-right: solid 1px #ababab;">
            <col style="width: 10%;border-right: solid 1px #ababab;">
            <col style="width: 10%;border-right: solid 1px #ababab;">
            <col style="width: 10%;border-right: solid 1px #ababab;">
            <col style="width: 10%;border-right: solid 1px #ababab;">
            <col style="width: 10%;border-right: solid 1px #ababab;">
            <col style="width: 10%;border-right: solid 1px #ababab;">
            <col style="width: 10%;border-right: solid 1px #ababab;">
        </colgroup>
        
        <thead>
        <tr>
             <th>{{ trans($transKey.'.id.label') }}</th>
            <th>{{ trans($transKey.'.matr.label') }}</th>
            <th>{{ trans($transKey.'.full_name.label') }}</th>
            <th align="right">{{ trans($transKey.'.punt_progressione.label') }}</th>
            <th align="right"><b>{{ trans($transKey.'.totale.label') }}</b></th>
            {{--<th>{{ trans($transKey.'.totale_pond.label') }}</th> --}}
            <th align="right">{{ trans($transKey.'.excellences_count_last_3_years.label') }}</th>
            <th align="right">{{ trans($transKey.'.perf_ind_media.label') }}</th>
            <th align="right">{{ trans($transKey.'.gg_cateco_posfun_no_asz.label') }}</th>
            <th align="right">{{ trans($transKey.'.gg_esperienza_no_asz.label') }}</th>
            <th align="right">{{ trans($transKey.'.gg_in_sede.label') }}</th>
            <th align="right">{{ trans($transKey.'.eta.label') }}</th>
        </tr>
        </thead>
        <tbody>
    @foreach($rows as $cat=>$items)
        <tr>
            <td colspan="7" style="border-bottom: solid 1px #ababab;"><h3>{{ $cat }}</h3></td>
        </tr>
        @foreach($items as $row)
        <tr class="{{ $loop->index %2 ==0?'light':''}}">
             <td style="border-bottom: solid 1px #ababab;" >
                {{ $row->id }}
            </td>
            <td style="border-bottom: solid 1px #ababab;" >
                {{ $row->matr }}
            </td>
            <td style="border-bottom: solid 1px #ababab;">
                {{ $row->cognome }}<br/>{{ $row->nome }} 
            </td>
             <td style="border-bottom: solid 1px #ababab;" align="right">
                <b>{{ $row->punt_progressione }}</b>
             </td>
            <td style="border-bottom: solid 1px #ababab;" align="right">
                {{--<b>{{ $row->totale}}</b> --}}
                <b>{{ round($row->punt_progressione_finale,3) }}</b>
            </td>
            {{--
            <td style="border-bottom: solid 1px #ababab;" align="right">
                {{ $row->totale_pond}}
            </td>
            --}}
            <td style="border-bottom: solid 1px #ababab;" align="right">
                @if($row->excellences_count_last_3_years > 0)
                {{ $row->excellences_count_last_3_years }}
                @endif
            </td>
            <td style="border-bottom: solid 1px #ababab;" align="right">
                {{ number_format($row->perf_ind_media,2) }}
            </td>
            <td style="border-bottom: solid 1px #ababab;" align="right">
                {{ $row->gg_cateco_posfun_no_asz}}
            </td>
            <td style="border-bottom: solid 1px #ababab;" align="right">
                {{ $row->gg_esperienza_no_asz }}
            </td>
            <td style="border-bottom: solid 1px #ababab;" align="right">
                {{ $row->gg_in_sede}}
            </td>
            <td style="border-bottom: solid 1px #ababab;" align="right">
                {{ $row->eta}}
            </td>
        </tr>
        @endforeach
    @endforeach
     </tbody>
    </table>

    @include('ptv::pdf.firma')
</page>