nds('adm_theme::layouts.app')
@section('page_heading', 'Condizioni Lavoro')
@section('section')
    <x-filament::badge> flash-message </x-filament::badge>

    <a href="{{ route('indennita.condizionilavoro.scheda.index', $params) }}" class="btn btn-default">&laquo;&nbsp;Back</a>
    <hr />
    <b>lavoratore</b>: {{ $row->ente }}-{{ $row->matr }}] {{ $row->cognome }} {{ $row->nome }} <br />
    <b>giorni presenza anno</b>: {{ $row->gg_presenza_anno }}<br />
    <b>giorni presenza periodo</b>: <div id="gg_presenza_periodo">{{ $row->gg_presenza_periodo }}</div> <br />


    {{-- dddx($row->indennitaTipoDettaglio) --}}

    {!! Form::bsOpen($row, 'update') !!}

    {{ Form::bsDate('dal') }}
    {{ Form::bsDate('al') }}

    <table>
        <thead>
            <tr>
                <th>Tipo Indennita</th>
                <th>Dettaglio / gg diritto indennita </th>
            </tr>
        </thead>
        @foreach ($row->all_indennita_tipo as $tipo)
            @if ($tipo->dettaglio->count() > 0)
                <tr>
                    <td>{{ $tipo->nome }}</td>
                    <td>@include($view.'.dettaglio',['row'=>$tipo,'parent'=>$row])</td>

                </tr>
            @endif
        @endforeach
        <tr>
            <th colspan="1">TOT</th>
            <td align="right">
                <table>
                    <thead>
                        <tr>
                            <td>Tot GG</td>
                            <td>Euro Periodo</td>
                        </tr>
                    </thead>
                    <tr>
                        <td align="right">
                            <div id="tot" style="color:darkblue;font-weight:800;"></div>
                            {{ Form::hidden('totale') }}
                        </td>
                        <td align="right">
                            <div id="valore_tot" style="color:darkblue;font-weight:800;"></div>
                            {{ Form::hidden('valore_tot') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    {{ Form::bsSubmit('modifica!') }}

    {{ Form::close() }}
@endsection

@push('scripts')
    <script type="text/javascript">
        function aggiornaTot() {
            $tot = 0;
            $('input[name*="gg"]').each(function() {
                $v = parseFloat($(this).val());
                if (isNaN($v)) {
                    //$(this).val(0);
                    $v = 0;
                }
                $tot = $v + $tot;
            });
            $('#tot').html($tot);
            $("input[name='totale']").val($tot);
            $gg_presenza_periodo = $('#gg_presenza_periodo').text();
            if ($tot > $gg_presenza_periodo) {
                alert('non puoi assegnare piu\' giorni di quelli che ha fatto');
            }


        }

        function aggiornaPerc() {
            $gg_presenza_periodo = $('#gg_presenza_periodo').text();
            $('input[name*="gg"]').each(function() {
                $v = parseFloat($(this).val());
                if (isNaN($v)) {
                    //$(this).val(0);
                    $v = 0;
                }
                $id = $(this).data('id');
                if ($gg_presenza_periodo != 0) {
                    $perc = $v / $gg_presenza_periodo;
                } else {
                    $perc = 0;
                }
                $('#perc_' + $id).text($perc.toFixed(3));
                $euro_giorno = $('#euro_giorno_' + $id).text();
                $soldi = $v * $euro_giorno;
                $('#soldi_' + $id).text($soldi.toFixed(3));
            });

            $valore_tot = 0;
            $('div[id*="soldi_"]').each(function() {
                $v = parseFloat($(this).text());
                if (isNaN($v)) {
                    //$(this).val(0);
                    $v = 0;
                }
                $valore_tot = $v + $valore_tot;
            });
            $('#valore_tot').html($valore_tot.toFixed(3));
            $("input[name='valore_tot']").val($valore_tot.toFixed(3));
        }


        $("input:text").on("keyup", function(e) {
            aggiornaPerc(e);
            //aggiornaSoldi();
            aggiornaTot();
        });
        aggiornaTot();
        aggiornaPerc();
    </script>
@endpush
