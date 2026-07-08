nds('adm_theme::layouts.app')
@section('page_heading','Indennita Tipo Dettaglio')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

{!! Form::bsYearNav(['routename'=>'indennita.condizionilavoro.anno.indennitatipodettaglioanno.index']) !!}
{!! Form::bsBtnCreate() !!}
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<td>ID</td>
			<td>indennita tipo</td>
			<td>dettaglio</td>
			<td>dal - al</td>
			<td>&euro; Giorno</td>
			<td>only disci1</td>
			<td>only codqua</td>
			<td>except disci1</td>
			<td>except codqua</td>

			<td></td>
		</tr>
	</thead>
	<tbody>
		@foreach($rows as $row)
		<tr>
			<td>{{ $row->id }}</td>
			<td>{{ $row->indennita_tipo_id }}] {{ $row->indennitaTipo->nome }}</td>
			<td>{{ $row->nome }}</td>
			<td>{{ $row->dal }} - {{ $row->al }}</td>
			<td>{{ $row->euro_giorno }} </td>
			<td>{{ $row->only_disci1 }} </td>
			<td>{{ $row->only_codqua}} </td>
			<td>{{ $row->except_disci1}}</td>
			<td>{{ $row->except_codqua}} </td>

			<td>{!! Form::bsBtnEdit(['row'=>$row]) !!}</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endsection
