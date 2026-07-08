nds('adm_theme::layouts.app')

@section('page_heading','Lista Periodi in Sede con Propro posfun')
@section('section')


<a href="{{  route('progressioni.schede_ente_stabi_repar_anno.index',getRouteParameters()) }}" class="btn btn-success">&laquo; schede</a> <br/>
{{ $rows->links() }}
<table class="table table-striped table-bordered">
<thead>
<tr>
<td>dal</td>
<td>al</td>
<td>asztip - aszcod</td>
<td>Ore</td>
<td>Giorni</td>
<td></td>
</tr>
</thead>
<tbody>
@foreach($rows as $k => $v)
	<tr>
		<td>{{ Carbon\Carbon::parse($v->asz2kd)->formatLocalized('%d/%m/%Y') }}</td>
		<td>{{ Carbon\Carbon::parse($v->asz2ka)->formatLocalized('%d/%m/%Y') }}</td>
		<td>
			{{ $v->asztip }} - {{ $v->aszcod }}
			<br/>{{ $v->Codici['field2'] }}
		</td>
		@if($v->aszumi=='O')
		<td>
			{{ $v->aszdur }}  {{-- $v->aszumi --}}
		</td>
		@else
		<td></td>
		@endif
		@if($v->aszumi=='G')
		<td>
			{{ $v->aszdur }}  {{-- $v->aszumi --}}
		</td>
		@else
		<td></td>
		@endif

		<td align="right">{{-- $v->giorni() --}}</td>

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
{{-- $rows->links() --}}

@endsection
