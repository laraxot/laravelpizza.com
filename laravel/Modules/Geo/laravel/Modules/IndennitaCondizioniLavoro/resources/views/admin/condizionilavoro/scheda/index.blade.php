nds('adm_theme::layouts.app')
@section('page_heading','Condizioni Lavoro')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


<table class="table table-striped table-bordered">
<thead>
	<tr>
		<td>lavoratore</td>
		<td>categoria eco</td>
		{{--  <td>dal - al</td> --}}
		<td></td>
	</tr>
</thead>
<tbody>
	@foreach($rows->get() as $row)
	<tr>
		<td>{{ $row->ente }}-{{ $row->matr }}<br/>
			{{ $row->cognome }} {{ $row->nome }}
		</td>
		<td>
			{{ $row->propro }}-{{ $row->posfun }}]{{ $row->categoria_eco }}<br/>
			<small>{{ $row->qua2kd }} - {{ $row->qua2ka }}</small>
		</td>
		{{--
		<td>
		{{ $row->dal->format('d/m/Y') }} - {{ $row->al->format('d/m/Y') }}
		</td>
		--}}
		<td>
			{{--
			{!! Form::bsBtnEdit(['row'=>$row]) !!}
			--}}
			<a href="{{-- route('indennita.condizionilavoro.scheda.trimestre.index',array_merge(['id_scheda'=>$row->id],$params)) --}}">
				<i class="fa fa-calendar" aria-hidden="true"></i>
			</a>
		</td>

	</tr>
	@endforeach
</tbody>
</table>

@endsection
