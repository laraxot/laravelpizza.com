ude('ptv::css.pdf')

<page backtop="23mm">
    <page_header>
        @include('ptv::intestazione')
    </page_header>
    @foreach($rows as $row)
    @if($loop->first)
    @php
    $msg=$row->messages->keyBy('type');
    @endphp
    <h3 style="text-align: center">
        {{--
        {!! nl2br($msg['graduatoria_su1']->txt) !!}
        --}}
        {!! $row->msg('graduatoria_su') !!}
        <br />
        {{ $row->valutatore->nome_stabi }}
    </h3>
    <div style="text-align: center">
        <table class="table morpion">
            <thead>
                <tr>
                    <th colspan="4">Categoria Giuridica: {{ $row->categoria_ecoval }}</th>
                </tr>
                <tr>

                    <th>N</th>
                    <th>ID</th>
                    {{--
                    <th>Matr</th>
                    <th>Lavoratore</th>
                    --}}

                    <th>Punteggio</th>
                    {{--
                    <th>Classifica</th>
                    --}}
                    <th>Beneficiario</th>
                </tr>
            </thead>
            @endif
            <tr>

                <td>{{ $loop->index+1 }}</td>
                <td>{{ $row->id }}</td>
                {{--
                <td>{{ $row->matr }}</td>
                <td>{{ $row->cognome }} {{ $row->nome }}</td>
                --}}

                <td align="right">{{ number_format($row->punt_progressione_finale,2) }}</td>
                {{--
                <td align="right">{{ $loop->index+1 }}</td>
                --}}
                <td align="center">
                    @if($row->benificiario_progressione)
                    X
                    @endif
                </td>
                {{--
                <td>{{ $row->valutatore_id }}</td>
                --}}
            </tr>
            @if($loop->last)
        </table>
    </div>
    <h5>
        {{--
        {!! nl2br($msg['graduatoria_giu']->txt) !!}
        --}}
        {!! $row->msg('graduatoria_giu') !!}
    </h5>
    @endif
    @endforeach
    @include($view.'.footer')
    {{--
    <page_footer>
        @include($view.'.footer')
    </page_footer>
    --}}
</page>