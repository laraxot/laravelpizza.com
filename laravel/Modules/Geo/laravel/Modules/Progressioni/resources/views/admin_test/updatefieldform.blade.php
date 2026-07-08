nds('adm_theme::layouts.app')
@section('page_heading','Update Fields')
@section('section')

<h3>ESCLUSI : {{ $esclusi->count() }}</h3>
<table class="table table-striped table-bordered">

@foreach($esclusi->get() as $row)
<tr>
	<td>{{ $row->id }}</td>
	<td>{{ $row->matr }}</td>
	<td>{{ $row->cognome }} {{ $row->nome }}</td>
	<td>{{ $row->motivo }}</td>
</tr>
@endforeach
</table>
@endsection