iorni Aspettative Ponderate Fuori Sede [aspettative_progressione_fuori_sede &amp; codici_assenze_progressione]</h2>
<table class="table table-striped table-bordered ">
<thead>
	<tr>
		<th>id</th>
		<th>tipo</th>
		<th>codice</th>
		<th>propro</th>
		<th>categoria eco</th>
		<th>posfun</th>
		{{--
		<th>propro-posfun-val</th>
		--}}
		<th>dal</th>
		<th>al</th>
		<th>gg</th>
		<th>peso</th>
		<th>gg_pond</th>
	</tr>
</thead>
<tbody>
@php
	$tot=0;
	$tot_pond=0;
@endphp
@foreach($aspettativeFuoriSede->get() as $row)
	<tr>
		<td>{{ $row->id }}</td>
		<td>{{ $row->asztip }}</td>
		<td>{{ $row->aszcod }}</td>
		<td>{{ $row->propro }}</td>
		<td>{{ $row->categoria_eco }}</td>
		<td>{{ $row->posfun }}</td>
		{{--  <td>{{ $row->propro_val }}-{{ $row->posfun_val }}</td> --}}
		<td>{{ $row->dal }}</td>
		<td>{{ $row->al }}</td>
		<td align="right">{{ $row->gg }}</td>
		<td align="right">{{ $row->peso }}</td>
		<td align="right">{{ $row->gg_pond }}</td>
		@php
			$tot+=$row->gg;
			$tot_pond+=$row->gg_pond;
		@endphp
	</tr>
@endforeach
<tr>
	<td colspan="8"><b>Tot</b></td>
	<td align="right"><b>{{ $tot }}</b></td>
	<td colspan="1"><b>Tot Pond</b></td>
	<td align="right"><b>{{ $tot_pond }}</b></td>
</tr>
</tbody>
</table>