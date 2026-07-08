nds('adm_theme::layouts.app')
@section('page_heading','Coeff')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

{!! Form::bsBtnCreate() !!}

<table class="table table-striped table-bordered">
<thead>
<tr>
	<td>ID</td>
	<td>gg in_sede</td>
	<td>gg fuori_sede</td>
	<td>gg propro in_sede</td>
	<td>gg propro fuori_sede</td>
	<td>gg propro posfun in_sede</td>
	<td>gg propro posfun fuori_sede</td>
	<td>gg no_propro posfun in_sede</td>
	<td>gg no_propro posfun fuori_sede</td>
	<td>anno</td>
	<td></td>
</tr>
</thead>
<tbody>
@foreach($rows as $k =>$v)
<tr>
	<td>{{ $v->id }}</td>
	<td>{{ $v->gg_in_sede }}</td>
	<td>{{ $v->gg_fuori_sede }}</td>
	<td>{{ $v->gg_propro_in_sede }}</td>
	<td>{{ $v->gg_propro_fuori_sede }}</td>
	<td>{{ $v->gg_propro_posfun_in_sede }}</td>
	<td>{{ $v->gg_propro_posfun_fuori_sede }}</td>
	<td>{{ $v->gg_no_propro_posfun_in_sede }}</td>
	<td>{{ $v->gg_no_propro_posfun_fuori_sede }}</td>
	<td>{{ $v->anno }}</td>
	<td>{!! Form::bsBtnEdit(['id_coeff'=>$v->id]) !!}</td>
</tr>
</tbody>
@endforeach

</table>
@endsection
