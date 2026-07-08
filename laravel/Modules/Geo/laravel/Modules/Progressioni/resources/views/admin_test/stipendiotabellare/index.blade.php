nds('adm_theme::layouts.app')
@section('page_heading','Stipendio Tabellare')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


{!! Form::bsYearNav(['routename'=>'progressioni.stipendio_tabellare.anno.index']) !!}
{!! Form::bsBtnCreate() !!}
<pre>
	euro_pond e ptime ci sono perche' importati con una query, viene preso quello con ptime maggiore,
	quasi sempre c'e' un ptime a 1 percio' senza arrotondamenti
</pre>
<table class="table table-striped table-bordered">
<thead>
<tr>
	<td>ID</td>
	<td>Cat</td>
	<td>propro</td>
	<td>posfun</td>
	<td> euro_pond </td>
	<td> ptime </td>
	<td> euro </td>

	<td>anno</td>
	<td></td>
</tr>
</thead>
<tbody>
@foreach($rows as $k =>$v)
<tr>
	<td>{{ $v->id }}</td>
	<td>{{ $v->categoria }}</td>
	<td>{{ $v->propro }}</td>
	<td>{{ $v->posfun }}</td>
	<td>{{ $v->euro_pond }}</td>
	<td>{{ $v->ptime }}</td>
	<td>{{ $v->euro }}</td>

	<td>{{ $v->anno }}</td>
	<td>
		@if(isset($anno))
		{!! Form::bsBtnCrud(['row'=>$v]) !!}
		@endif
	</td>
</tr>
</tbody>
@endforeach

</table>
{{$rows->links()}}
@endsection
