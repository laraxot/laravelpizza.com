nds('adm_theme::layouts.app')

@section('page_heading','Lista Periodi Fuori Sede')
@section('section')


<a href="{{  route('progressioni.schede_ente_stabi_repar_anno.index',getRouteParameters()) }}" class="btn btn-success">&laquo; schede</a>

<table class="table table-striped table-bordered">
<thead>
<tr>
<td>dal</td>
<td>al</td>
<td>dove</td>
<td>giorni</td>
</tr>
</thead>
<tbody>
@foreach($rows->get() as $k => $v)
	<tr>
		<td>{{ Carbon\Carbon::parse($v->q32kd)->formatLocalized('%d/%m/%Y') }}</td>
		<td>{{ Carbon\Carbon::parse($v->q32ka)->formatLocalized('%d/%m/%Y') }}</td>
		<td>{{ $v->q3desc }} {{ $v->q3desc2 }} {{ $v->q3desc3 }}</td>
		<td align="right">{{ $v->giorni() }}</td>
	</tr>
@endforeach
</tbody>
<tfoot>
	<tr>
	<td colspan="3"> </td>
	<td></td>
	</tr>
</tfoot>
</table>

@endsection
