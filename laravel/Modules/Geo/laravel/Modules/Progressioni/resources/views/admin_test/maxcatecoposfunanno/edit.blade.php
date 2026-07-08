nds('adm_theme::layouts.app')
@section('page_heading','Max Cateco posfun ')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

{{ $row->cateco }} - {{ $row->posfun }}
@php
	$rows=$row->schede();
	//echo '<pre>';print_r($rows->toSql());echo '</pre>';
	//echo '<pre>';print_r($rows->get());echo '</pre>';
@endphp
@include($view.'.nav')
 @include($view.'.htmlitem')
<table class="table table-striped table-bordered">
<thead>
	<tr>
		<td>N</td>
		<td>Lavoratore</td>
		<td>categoria</td>
		<td>gg tot pond</td>
		<td>esperienza aquisita</td>
		<td>totale</td>
		<td>vincitore</td>
	</tr>

</thead>
@foreach($rows->distinct()->where('ha_diritto',1)->orderBy('totale','desc')->orderBy('gg_tot_pond','desc')->groupBy('matr')->where('totale','>',0)->get() as $k=>$row0)
<tr>
	<td>{{ $k+1 }}</td>
	<td>[{{ $row0->id }}] {{ $row0->ente }}-{{ $row0->matr }}<br/>
		{{ $row0->cognome }} {{ $row0->nome }}</td>
	<td>{{ $row0->categoria_ecoval }}-{{ $row0->posfun }}</td>
	<td align="right">{{ $row0->gg_tot_pond }}</td>
	<td align="right">{{ $row0->esperienza_acquisita }}</td>
	<td align="right">{{-- $row0->totale --}} {{-- totale_pond e' il totale ponderato per i periodi negli stabi --}}
		{{ number_format($row0->totale_pond,3) }}<br/>

	{{-- $row0->ha_diritto --}} {{ $row0->motivo }}</td>
	<td align="right">{{ $row0->vincitore }}</td>
</tr>
@endforeach
</table>


{!! Form::bsOpen($row,'update') !!}

{{ Form::bsText('anno') }}
{{ Form::bsText('max_gg_tot_pond') }}
{{ Form::bsText('aventi_diritto') }}
{{ Form::bsText('aventi_diritto_perc') }}
{{ Form::bsText('aventi_diritto_eff') }}


{{Form::bsSubmit('Salva ed esci')}}
{!! Form::close() !!}



@endsection
