ude($view.'.style')
<page style="font-size: 10pt">
@include($view.'.head',['row'=>$row])
<x-filament::badge> flash-message </x-filament::badge>

<h3 style="text-align:center;">SCHEDA DI VALUTAZIONE <br/>
	PROGRESSIONE ECONOMICA ORIZZONTALE <br/>
	ANNO {{ $params['anno']+1 }}
</h3>
<hr/>
<b>Dipendente:</b> {{$row->cognome}} {{$row->nome}} <b>matr:</b> {{$row->matr}} <b>Cat. Giur:</b> {{$row->categoria_eco }} <br/>
<b>Settore:</b> {{$row->stabi_txt}} <b>Reparto:</b> {{$row->repar_txt}}
<br/><br/><br/>
<table class="table table-striped table-bordered " >
	<col style="width: 60%">
	<col style="width: 10%">
    <col style="width: 10%">
    <col style="width: 10%">

<thead>
	<tr>
		<th>CRITERI DI VALUTAZIONE</th>
		<th>PUNTEGGIO ATTRIBUITI DAL DIRIGENTE</th>
		<th>PESO PERCORSO %</th>
		<th>PUNTEGGIO PONDERATO</th>
	</tr>
</thead>

@foreach($row->valutaz_fields as $field)
<tr>
	<td>{!! trans('progressioni::schede.'.$field.'_long') !!}</td>
	<td align="right">@if($row->$field>0){{  number_format($row->$field,2) }}@endif</td>
	@php
	 	$peso_field='peso_'.$field;
	@endphp
	<td align="right">{{ number_format($row->$peso_field,2) }}</td>
	<td align="right">@if($row->$field>0){{ number_format($row->$field * $row->$peso_field /100,3) }}@endif</td>
</tr>
@endforeach
<tr><td colspan="3"><b>Tot</b></td>
	<td align="right">
		<span id="tot" style="color:darkblue;font-weight:850;">@if($row->totale!=0){{ $row->totale }}@endif</span>
	</td>
</tr>
</table>



@include($view.'.firma',['row'=>$row])
</page>
