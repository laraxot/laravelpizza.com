e class="table table-striped table-bordered ">
<thead>
	<tr>
	<td>criterio</td>
	<td>valore</td>
	<td>peso %</td>
	<td></td>
	</tr>
</thead>
@php
@endphp
@foreach($row->valutaz_fields as $kv => $vv)
<tr>
	<td>{!! str_replace('_','<br/>',$vv) !!}</td>
	<td align="right">{{ number_format($row->$vv,2) }}</td>
	<?php $skv = 'peso_'.$vv;
	?>
	<td align="right">{{ number_format($row->$skv,2) }}</td>
	<td align="right">{{ number_format($row->$vv * $row->$skv / 100,3) }}</td>
</tr>
@endforeach
<tr><th colspan="3">Tot</th><td align="right"><b>{{ number_format($row->totale,3) }}</b></td></tr>
</table>
{!! Form::bsBtnEdit(['id_schede'=>$row->id]) !!}
@if($row->updated_at!=null)
{{ $row->updated_at->format('d/m/Y') }}
@endif
