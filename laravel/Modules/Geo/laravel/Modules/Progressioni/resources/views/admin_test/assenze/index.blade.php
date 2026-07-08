nds('adm_theme::layouts.app')
@section('page_heading','Assenze')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


{!! Form::bsYearNav(['routename'=>'progressioni.anno_assenze.index']) !!}
{!! Form::bsBtnCreate() !!}

@if(isset($params['anno']))
<a class="btn btn-warning" href="{{ route('progressioni.anno_assenze.updateasz',$params) }}">Aggiorna Assenze {{ $params['anno'] }}</a>
@endif

<table class="table table-striped table-bordered">
<thead>
<tr>
	<td>ID</td>
	<td>tipo</td>
	<td>codice</td>
	<td>descr</td>
	<td>umi</td>
	<td>dur</td>
	<td>anno</td>
	<td></td>
</tr>
</thead>
<tbody>
@foreach($rows as $k =>$v)
<tr>
	<td>{{ $v->id }}</td>
	<td>{{ $v->tipo }}</td>
	<td>{{ $v->codice }}</td>
	<td>{{ $v->descr }}</td>
	<td>{{ $v->umi }}</td>
	<td>{{ $v->dur }}</td>
	<td>{{ $v->anno }}</td>
	<td>{!! Form::bsBtnCrud(['id_assenze'=>$v->id]) !!}</td>
</tr>
</tbody>
@endforeach

</table>
{{$rows->links()}}
@endsection
