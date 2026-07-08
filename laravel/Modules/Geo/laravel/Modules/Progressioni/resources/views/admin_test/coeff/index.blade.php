nds('adm_theme::layouts.app')
@section('page_heading','Coeff')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


{!! Form::bsYearNav(['routename'=>'progressioni.anno_coeff.index']) !!}
{!! Form::bsBtnCreate() !!}

<table class="table table-striped table-bordered">
<thead>
<tr>
	<td>ID</td>
	<td>name</td>
	<td>value</td>
	<td>anno</td>
	<td></td>
</tr>
</thead>
<tbody>
@foreach($rows as $k =>$v)
<tr>
	<td>{{ $v->id }}</td>
	<td>{{ $v->name }}</td>
	<td>{{ $v->value }}</td>
	<td>{{ $v->anno }}</td>
	<td>
		{!! Form::bsBtnCrud(['id_coeff'=>$v->id]) !!}
		{!! Form::bsBtnClone(['id_coeff'=>$v->id]) !!}
	</td>
</tr>
</tbody>
@endforeach

</table>
{{$rows->links()}}
@endsection
