iorni propro in sede [qua00f]</h2>
<table class="table table-striped table-bordered ">
<thead>
	<tr>
		<td>id</td>
		<td>propro</td>
		<td>categoria eco</td>
		<td>posfun</td>
		<td>dal</td>
		<td>al</td>
		<td>gg</td>
	</tr>
</thead>
<tbody>
	@php
		$tot=0;
	@endphp
	@foreach($anag->qua00f()->orderBy('qua2kd')->get() as $row)
		<tr>
			<td>{{ $row->id }}</td>
			<td>{{ $row->propro }}</td>
			<td>{{ $row->categoria_eco }}</td>
			<td>{{ $row->posfun }}</td>
			<td>{{ $row->qua2kd }}</td>
			<td>{{ $row->qua2ka }}</td>
			@php
				$curr=	$row->gg(['date_max'=>$date_max
								,'date_min'=>$date_min
								//,'propro'=>$schede->first()->propro
								,'categoria_eco'=>$schede->first()->categoria_ecoval
								]);
				$tot+=$curr;
			@endphp
			<td align="right">{{ $curr }}</td>
		</tr>
	@endforeach
		<tr><th colspan="6">TOT</th><td align="right"><b>{{ $tot }}</b></td></tr>
</tbody>
</table>

