nds('adm_theme::layouts.app')
@section('page_heading','Condizioni Lavoro')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


<div class="btn-group" role="group" aria-label="Basic Action">
<a href="{{ route('indennita.condizionilavoro.index',$params) }}" class="btn btn-default btn-secondary">
	<i class="fas fa-step-backward fa-1x"></i>&nbsp;Back</a>
@for($i=1;$i<=4;$i++)
	@php
		$parz=$params;
		$parz['trimestre']=$i;
	@endphp
	<a href="{{ route('indennita.condizionilavoro.schedapdf',$parz) }}" class="btn btn-default btn-secondary">
		<i class="far fa-file-pdf fa-1x"></i>&nbsp;PDF {{ $i }} Trimestre
	</a>
	<a href="{{ route('indennita.condizionilavoro.schedaxls',$parz) }}" class="btn btn-default btn-secondary">
		<i class="far fa-file-excel fa-1x"></i>&nbsp;XLS {{ $i }} Trimestre
	</a>
@endfor

</div>

@include('ptv::completeforms.update_firma')

<h3>Anno:{{ $anno }}</h3>
<table class="table table-striped table-bordered">
<thead>
	<tr>
		<td>lavoratore</td>

		<td>{{--  categoria eco --}}</td>
		{{--  <td>dal - al</td> --}}
		<td></td>
	</tr>
</thead>
<tbody>
	@foreach($rows->get() as $row)
	<tr>
		<td>{{ $row->ente }}-{{ $row->matr }}<br/>
			{{ $row->cognome }} {{ $row->nome }}
		</td>
		<td>

			{{--
			@foreach(->qua00f as $qua00f)
			{{ $qua00f->propro }}-{{ $qua00f->posfun }}]{{ $qua00f->categoria_eco }}<br/>
			<small>{{ $qua00f->qua2kd }} - {{ $qua00f->qua2ka }}</small>
			@endforeach
			--}}
		</td>
		{{--
		<td>
		{{ $row->dal->format('d/m/Y') }} - {{ $row->al->format('d/m/Y') }}
		</td>
		--}}
		<td>
			{{--
			{!! Form::bsBtnEdit(['row'=>$row]) !!}
			--}}
			<a href="{{ route('indennita.condizionilavoro.scheda.trimestre.index',array_merge(['matr'=>$row->matr],$params)) }}">
				<i class="fa fa-calendar" aria-hidden="true"></i>
			</a>
		</td>

	</tr>
	@endforeach
</tbody>
</table>

@endsection
