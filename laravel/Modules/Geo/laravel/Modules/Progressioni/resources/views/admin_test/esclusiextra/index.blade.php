nds('adm_theme::layouts.app')
@section('page_heading','Esclusi Extra')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


{!! Form::bsYearNav(['routename'=>'progressioni.anno_esclusiextra.index']) !!}
{!! Form::bsBtnCreate() !!}

<table class="table table-striped table-bordered">
<thead>
<tr>
	<td>ID</td>
	<td>lavoratore</td>
	<td>motivo</td>
	<td>anno</td>
	<td></td>
</tr>
</thead>
<tbody>
@foreach($rows as $k =>$v)
@if($k==0)
	{{ $v->updateFields() }}
@endif
<tr>
	<td>{{ $v->id }}</td>
	<td>{{ $v->ente }}-{{ $v->matr }}<br/>
	{{ $v->cognome }} {{ $v->nome }}</td>
	<td>{{ $v->motivo }}</td>
	<td>{{ $v->anno }}</td>
	<td>
		{!! Form::bsBtnCrud(['id_esclusiextra'=>$v->id]) !!}
		{!! Form::bsBtnClone(['id_esclusiextra'=>$v->id]) !!}
	</td>
</tr>
</tbody>
@endforeach

</table>
{{ $rows->links() }}
@endsection
