nds('adm_theme::layouts.app')
@section('page_heading','Casi Particolari Anno')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

{!! Form::bsYearNav(['routename'=>'indennita.servizioesterno.anno.casiparticolari.index']) !!}
{!! Form::bsBtnCreate() !!}
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<td>ID</td>
			<td>Lavoratore</td>
			<td>Status/Note</td>
			<td>anno</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		@foreach($rows as $row)
		<tr>
			<td>{{ $row->id }}</td>
			<td>{{ $row->ente }} - {{ $row->matr }}
				<br/>{{ $row->cognome }} {{ $row->nome }}
			</td>
			<td><b>{{ $row->status_txt }}</b><br/>{{ $row->note }} </td>
			<td>{{ $row->anno}} </td>
			<td>{!! Form::bsBtnCrud(['row'=>$row]) !!}</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endsection
