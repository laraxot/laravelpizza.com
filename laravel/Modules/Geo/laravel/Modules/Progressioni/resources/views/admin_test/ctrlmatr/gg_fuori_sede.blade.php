iorni fuori sede [qua03f]</h2>
<table class="table table-striped table-bordered ">
<thead>
	<tr>
		<td>id</td>
		<td>descr</td>
		<td>assunzione</td>
		<td>dimissioni</td>
		<td align="right">gg</td>
	</tr>
</thead>
<tbody>
	@php
		$tot=0;
	@endphp
	@foreach($anag->qua03f()->get() as $row)
		<tr>
			<td>{{ $row->id }}</td>
			<td>{{ $row->q3desc }}</td>
			<td>{{ $row->q32kd }}</td>
			<td>{{ $row->q32ka }}</td>
			@php
				$curr=$row->gg(['date_max'=>$date_max,'date_min'=>$date_min]);
				$tot+=$curr;
			@endphp
			<td align="right">{{ $curr }}</td>
		</tr>
	@endforeach
	<tr><td colspan="4"><b>Tot</b></td><td align="right"><b>{{ $tot }}</b></td></tr>
</tbody>
</table>