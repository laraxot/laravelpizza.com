nds('adm_theme::layouts.app')

@section('page_heading','Lista Periodi in Sede')
@section('section')

<a href="{{  route('progressioni.schede_ente_stabi_repar_anno.index',getRouteParameters()) }}" class="btn btn-success">&laquo; schede</a>

<table class="table table-striped table-bordered">
<thead>
<tr>
<td>dal</td>
<td>al</td>
<td>giorni</td>
</tr>
</thead>
<tbody>
@foreach($rows->get() as $k => $v)
	<tr>
		<td>{{ $v->st2kas}}</td>
		<td>{{ $v->st2kdi }}</td>
		<td>{{ $v->giorni() }}</td>
	</tr>
@endforeach
</tbody>
</table>

@endsection
