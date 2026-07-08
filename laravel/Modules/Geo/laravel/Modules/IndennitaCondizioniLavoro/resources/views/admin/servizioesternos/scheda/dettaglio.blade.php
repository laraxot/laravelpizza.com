nds('adm_theme::layouts.app')
@section('page_heading','Servizio Esterno')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

<a href="{{ route('indennita.servizioesterno.scheda.index',$params) }}" class="btn btn-default">&laquo;&nbsp;Back</a>
<hr/>
<b>lavoratore</b>: {{ $row->ente }}-{{ $row->matr }}] {{ $row->cognome }} {{ $row->nome }}	<br/>
<b>N trasferte {{ $row->anno }}</b>: {{ $row->trasferte->count() }}<br/>
<b>giorni trasferte anno</b>: {{ $row->gg_trasferte_anno }}<br/>
<b>giorni presenza anno</b>: {{ $row->gg_presenza_anno }}<br/>
<b>giorni assenza anno</b>: {{ $row->gg_assenza_anno }} <br/>
<b>ore assenza anno</b>: {{ $row->hh_assenza_anno }} <br/>

{{--
<table class="table table-striped table-bordered">
		<tr>
	@foreach($row->giorni_trasferte as $t)
			<td>{{ $t }}</td>
	@endforeach
		</tr>
</table>
--}}
<h3>Trasferte Anno</h3>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>id<br/>stato</th>
			<th>dal</th>
			<th>al</th>
			<th>giorni</th>
			<th>partenza<br/>luogo trasferta</th>
			<th>motivo</th>
		</tr>
	</thead>
	@foreach($row->trasferte->sortBy('data_start') as $trasf)
	<tr>
		<td>{{ $trasf->id }}<br/>
			<span style="background-color:{{ $trasf->approvaz->col }};">
				{{ $trasf->last_stato }}]{{ $trasf->last_stato_txt }}
			</span>
		</td>
		<td> {{ $trasf->dal->format('d/m/Y H:i') }} </td>
		<td> {{ $trasf->al->format('d/m/Y H:i') }} </td>
		{{-- <td> {{ $trasf->durata }} </td> --}}
		<td> {{ $trasf->giorni }} </td>
		<td> {{ $trasf->id_luogo_start_txt }} <br/>
			{{ $trasf->id_luogo_end_txt }}
		</td>
		<td>
			<b>{{ $trasf->motivo_txt }}</b><br/>
			{{ $trasf->note }}
		</td>
	</tr>
	@endforeach
</table>


@endsection
