nds('adm_theme::layouts.app')

@section('page_heading','Lista Periodi in Sede con Propro posfun')
@section('section')


<a href="{{  route('progressioni.schede_ente_stabi_repar_anno.index',getRouteParameters()) }}" class="btn btn-success">&laquo; schede</a>

<table class="table table-striped table-bordered">
<thead>
<tr>
<td>dal</td>
<td>al</td>
<td>propro - posfun</td>
<td>giorni</td>
{{--
<td>giorni ProPro</td>
<td>giorni PosFun</td>
--}}
</tr>
</thead>
<tbody>
@foreach($rows->get() as $k => $v)
	<tr>
		<td>{{ Carbon\Carbon::parse($v->qua2kd)->formatLocalized('%d/%m/%Y') }}</td>
		<td>
		@if($v->qua2ka==0)
		@else
			{{ Carbon\Carbon::parse($v->qua2ka)->formatLocalized('%d/%m/%Y') }}
		@endif
		</td>
		<td>
			{{ $v->propro }} - {{ $v->posfun }}
			<br/> {{ $v->tqu00f['desc1'] }}
			<br/> {{ $v->tqu00f['desc2'] }}
		</td>


		<td align="right">{{ $v->giorni() }}</td>
		{{--
		<td align="right">{{ $v->giorni_propro() }}</td>
		<td align="right">{{ $v->giorni_propro_posfun() }}</td>
		--}}
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
