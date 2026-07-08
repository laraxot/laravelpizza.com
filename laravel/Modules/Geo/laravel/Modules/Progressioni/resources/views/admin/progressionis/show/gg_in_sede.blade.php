iorni in sede [sto00f]</h2>
<table class="table table-striped table-bordered ">
<thead>
	<tr>
		<td>id</td>
		<td>assunzione</td>
		<td>dimissioni</td>
		<td>gg</td>
	</tr>
</thead>
<tbody>
	@foreach($anag->sto00f()->get() as $row)
		<tr>
			<td>{{ $row->id }}</td>
			<td>{{ $row->st2kas }}</td>
			<td>{{ $row->st2kdi }}</td>
			<td align="right">{{ $row->gg(['date_max'=>$date_max,'date_min'=>$date_min]) }}</td>
		</tr>
	@endforeach
</tbody>
</table>
<h2>giorni in sede [qua00f]</h2>
<table class="table table-striped table-bordered ">
<thead>
	<tr>
		<td>id</td>
		<td>dal</td>
		<td>al</td>
		<td>gg</td>
	</tr>
</thead>
<tbody>
	@php
		$tot=0;
	@endphp
	@foreach($anag->qua00f()->get() as $row)
		<tr>
			<td>{{ $row->id }}</td>
			<td>{{ $row->qua2kd }}</td>
			<td>{{ $row->qua2ka }}</td>
			@php
				$curr=	$row->gg(['date_max'=>$date_max
								,'date_min'=>$date_min
								//,'propro'=>$schede->first()->propro
								//,'categoria_eco'=>$schede->first()->categoria_ecoval
								]);
				$tot+=$curr;
			@endphp
			<td align="right">{{ $curr }}</td>

		</tr>
	@endforeach
	<tr><th colspan="3">TOT</th><td align="right"><b>{{ $tot }}</b></td></tr>
</tbody>
</table>

