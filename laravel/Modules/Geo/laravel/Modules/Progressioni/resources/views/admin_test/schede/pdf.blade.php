ude($view.'.style')
<page style="font-size: 10pt">
@include($view.'.head',['row'=>$rows->get()[0]])
<br/><br/>
<table class="table">
	<col style="width: 10%">
	<col style="width: 7%">
	<col style="width: 5%">
	<col style="width: 5%">
	<col style="width: 5%">
	<col style="width: 5%">
	<col style="width: 5%">
	<col style="width: 5%">
	<col style="width: 5%">
	<col style="width: 5%">
	<col style="width: 5%">
	<col style="width: 5%">
	<col style="width: 5%">

	@foreach($rows->orderBy('categoria_ecoval','desc')
			->orderBy('posfunval','desc')
			->orderBy('totale_pond','desc')
			->get() as $k=>$row)
	@if($row->totale>0 && $row->ha_diritto==1)
	@if($k==0)
	<tr>
		<td><b>Lavoratore</b></td>
		<td><b>Categoria</b></td>
		@foreach($row->valutaz_fields as $field)
		<td>
			<div style="rotate: 90;"><b>{{ str_replace('_',' '.chr(13),$field) }}</b></div>
		</td>
		<td >
			<div style="rotate: 90;"><b>peso {{ str_replace('_',' '.chr(13),$field) }} %</b></div>
		</td>
		@endforeach
		<td><b style="color:darkblue;">Tot</b></td>
	</tr>
	@endif
	<tr>
		<td>{{ $row->id }}<br/>
			{{ $row->ente }}-{{ $row->matr }}<br/>
			{{ $row->cognome }} {{ $row->nome }}
		</td>
		<td>
			{{ $row->categoria_ecoval }}-{{ $row->posfun }}
		</td>
		@foreach($row->valutaz_fields as $field)
		<td style="background-color: lightgreen;" align="right">
			{{ $row->$field }}

		</td>
		@php
			$peso_field='peso_'.$field;
		@endphp
		<td align="right">
			{{ $row->$peso_field }}
		</td>
		@endforeach
		<td align="right" style="background-color: lightblue;">
			{{ number_format($row->totale,3) }}
			@if($row->totale!=$row->totale_pond)
			<br/>POND: {{ number_format($row->totale_pond,3) }}
			@endif
		</td>

	</tr>
	@endif
	@endforeach
</table>
{{--
<h3>Under Costruction.. attendere.. </h3>
--}}
@include($view.'.firma',['row'=>$rows->get()[0]])
</page>