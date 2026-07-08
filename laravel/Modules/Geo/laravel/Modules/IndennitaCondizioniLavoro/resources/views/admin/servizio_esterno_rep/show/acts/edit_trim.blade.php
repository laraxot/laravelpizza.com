nds('adm_theme::layouts.app')
@section('page_heading', 'Servizio Esterno')
@section('section')
    <x-filament::badge> flash-message </x-filament::badge>


    {!! Form::model($row, ['url' => Request::fullUrl()]) !!}
    @method('put')

    <a href="{{ Panel::make()->get($row0)->url('index') }}" class="btn btn-default">&laquo;&nbsp;Back</a>


    <hr />
    <b>Scheda ID:</b>[{{ $row->id }}]<br />
    <b>Lavoratore:</b> {{ $row->ente }}-{{ $row->matr }}] {{ $row->cognome }} {{ $row->nome }} <br />
    {{-- <b>giorni presenza anno</b>: {{ $row->gg_presenza_anno }}<br/> --}}
    <b>giorni presenza periodo:</b>{{ $row->gg_presenza_periodo }}
    <a href="{{ Request::fullUrlWithQuery(['refresh' => 1]) }}" data-toggle="tooltip" title="ricalcola il valore"><i
            class="fas fa-sync"></i></a>
    <br />
    {{ Form::bsText('tot_presenza_periodo_plus_no_timbr') }} <br />
    <b>Trimestre N:</b> {{ $id_trimestre }}
    {{-- <b>Dal</b> {{ $row->dal->format('d/m/Y') }} - <b>Al</b> {{ $row->al->format('d/m/Y') }} <br/> --}}
    <b>Perc P Time Anno:</b> {{ number_format($row->perc_p_time_year * 100, 2) }} % <br />
    <b>Perc P Time intervallo di date:</b> {{ number_format($row->perc_p_time_daterange * 100, 2) }} % <br />
    <div style="display:none">
        <b>Qualifica:</b> {{ $row->codqua }}] {{ $row->codqua_txt }} <br />
        <b>Disciplina:</b> {{ $row->disci1 }}]{{ $row->disci1_txt }} <br />
    </div>

    <div style="display:none">
        <span id="gg_presenza_periodo">{{ $row->gg_presenza_periodo }}</span>
        <span id="perc_p_time_year">{{ $row->perc_p_time_year }}</span>
        <span id="perc_p_time_daterange">{{ $row->perc_p_time_daterange }}</span>
    </div>
    <hr />
    {{-- dddx($row->indennitaTipoDettaglio) --}}
    {{-- <table>
	<thead>
		<tr>
			<td>matr</td>
			<td>qua2kd</td>
			<td>qua2ka</td>
			<td>oree</td>
			<td>oret</td>
			<td>giorni</td>
		</tr>
	</thead>
@foreach ($row->qua00fDaterange as $qua00f)
	<tr>
		<td>{{ $qua00f->matr }}</td>
		<td>{{ $qua00f->qua2kd->format('d/m/Y') }}</td>
		<td>{{ $qua00f->qua2ka }}</td>
		<td>{{ $qua00f->oree }}</td>
		<td>{{ $qua00f->oret }}</td>
		<td>{{ $qua00f->giorni }}</td>
	</tr>
@endforeach
</table> --}}
    {{-- <br/><b>gg ptime vert </b>: {{ $row->gg_p_time_vert_year }} --}}




    <table>
        <thead>
            <tr>
                <th>Tipo Indennita</th>
                <th>Dettaglio / gg diritto indennita </th>
            </tr>
        </thead>
        @foreach ($row->all_indennita_tipo as $tipo)
            @php
                $dettagli = $tipo->dettaglio->filter(function ($value, $key) use ($row) {
                    $codqua_arr = explode(',', $value->only_codqua);
                    $disci1_arr = explode(',', $value->only_disci1);

                    if ($value->only_codqua != '' || $value->only_disci1 != '') {
                        //return in_array($row->codqua,$codqua_arr) || in_array($row->disci1,$disci1_arr);
                        return true;
                    }
                    return false;
                });

            @endphp
            @if ($dettagli->count() > 0)
                <tr>
                    <td>{{-- $tipo->id --}}
                        @if ($tipo->id == 4)
                            <b style="color:navy">{{ $tipo->nome }}</b>
                        @else
                            {{ $tipo->nome }}
                        @endif
                    </td>
                    <td>@include($view.'.dettaglio',['row'=>$tipo,'parent'=>$row,'dettagli'=>$dettagli])</td>

                </tr>
            @endif
        @endforeach
        <tr>
            <th colspan="1">TOT</th>
            <td align="right">
                <table>
                    <thead>
                        <tr>
                            <th>Totale Giorni</th>
                            <th>Euro </th>
                            <th>Euro Part-time</th>
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
                        <td align="right">
                            <div id="valore_ptime_tot" style="color:darkblue;font-weight:800;"></div>
                            {{ Form::hidden('valore_ptime_tot') }}
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
            $gg_presenza_periodo_plus_no_timbr = $("input[name='tot_presenza_periodo_plus_no_timbr']").val();
            if ($tot > $gg_presenza_periodo_plus_no_timbr) {
                alert('I GIORNI ASSEGNATI SUPERANO I GIORNI DI PRESENZA EFFETTIVA ');
            }


        }

        function aggiornaPerc() {
            $gg_presenza_periodo = $('#gg_presenza_periodo').text();
            $gg_presenza_periodo_plus_no_timbr = $("input[name='tot_presenza_periodo_plus_no_timbr']").val();
            $perc_p_time_year = $('#perc_p_time_year').text();
            $perc_p_time_daterange = $('#perc_p_time_daterange').text();


            $('input[name*="gg"]').each(function() {
                $v = parseFloat($(this).val());
                if (isNaN($v)) {
                    //$(this).val(0);
                    $v = 0;
                }
                $id = $(this).data('id');
                /*
                if($gg_presenza_periodo!=0){
                	$perc=$v/$gg_presenza_periodo;
                }else{
                	$perc=0;
                }
                */
                if ($gg_presenza_periodo_plus_no_timbr != 0) {
                    $perc = $v / $gg_presenza_periodo_plus_no_timbr;
                } else {
                    $perc = 0;
                }
                $perc1 = $perc * 100;
                $('#perc_' + $id).text($perc1.toFixed(2) + ' %');
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
            $('#valore_tot').html('&euro; ' + $valore_tot.toFixed(2));
            $("input[name='valore_tot']").val($valore_tot.toFixed(3));

            //$valore_ptime_tot=$valore_tot*$perc_p_time_year;
            $valore_ptime_tot = $valore_tot * $perc_p_time_daterange;

            $('#valore_ptime_tot').html('&euro; ' + $valore_ptime_tot.toFixed(2));
            $("input[name='valore_ptime_tot']").val($valore_ptime_tot.toFixed(3));
        }


        $("input:text").on("keyup", function(e) {
            aggiornaPerc(e);
            //aggiornaSoldi();
            aggiornaTot();
        });
        $(document).ready(function() {
            $gg_presenza_periodo = $('#gg_presenza_periodo').text();
            $old = $("input[name='tot_presenza_periodo_plus_no_timbr']").val();
            if ($old == '' || $old == 0) {
                $("input[name='tot_presenza_periodo_plus_no_timbr']").val($gg_presenza_periodo);
            }
            aggiornaTot();
            aggiornaPerc();
        });
    </script>
@endpush
