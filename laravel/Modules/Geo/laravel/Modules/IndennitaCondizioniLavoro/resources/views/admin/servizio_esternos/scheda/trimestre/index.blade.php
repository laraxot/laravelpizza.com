nds('adm_theme::layouts.app')
@section('page_heading','indennita Servizio Esterno')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


<a href="{{ route('indennita.servizioesterno.scheda.index',$params) }}" class="btn btn-default">&laquo;&nbsp;Back</a>
@php
	$day_start=Carbon\Carbon::create($anno,1,1,0,0,0);
	$day_end=Carbon\Carbon::create($anno,1,1,0,0,0)->addMonths(3);
	$fields=['ente','matr','cognome','nome'];
@endphp

@foreach($fields as $f)
<br/>{{ $f }}:<b>{{ $anag->$f }}</b>
@endforeach


<table>
	<thead>
		<tr>
			<td>ID</td>
			<td>dal</td>
			<td>al</td>
			<td></td>
		</tr>
	</thead>
	@for($i=1;$i<=4;$i++)
	<tr>
		<td>{{ $i }}</td>
		<td>{{ $day_start->format('d/m/Y') }}</td>
		<td>{{ $day_end->subDay()->format('d/m/Y') }}</td>
		<td>
			<a class="btn btn-primary" href="{{ route('indennita.servizioesterno.scheda.trimestre.edit',array_merge(['id_trimestre'=>$i],$params)) }}">
				<i class="fa fa-pencil"></i>
			</a>

		</td>
	</tr>
	@php
		$day_start->addMonths(3);
		$day_end->addDay();
		$day_end->addMonths(3);
	@endphp
	@endfor
</table>

@endsection
