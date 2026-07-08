iorni categoria eco / posfun fuori sede [qua03f]</h2>
<table class="table table-striped table-bordered ">
<thead>
	<tr>
		<td>id</td>
		<td>descr - tipo</td>
		<td>propro</td>
		<td>categoria eco</td>
		<td>posfun</td>
		<td>assunzione</td>
		<td>dimissioni</td>
		<td>gg</td>
	</tr>
</thead>
<tbody>
	@php
		$tot=0;
	@endphp
	@foreach($anag->qua03f as $row)
		<tr>
			<td>{{ $row->id }}</td>
			<td>{{ $row->q3desc }} - {{ $row->q3tipo }}</td>
			<td>{{ $row->q3pro }}</td>
			<td>{{ $row->categoria_eco }}</td>
			<td>{{ $row->q3fun }}</td>
			<td>{{ $row->q32kd }}</td>
			<td>{{ $row->q32ka }}</td>
			@php
				$curr=	$row->gg(['date_max'=>$date_max,'date_min'=>$date_min
								//,'propro'=>$scheda->propro
								,'categoria_eco'=>$scheda->categoria_ecoval
								,'posfun'=>$scheda->posfun]);
				$tot+=$curr;
			@endphp
			<td align="right">{{ $curr }}</td>
		</tr>

	@endforeach

	{{--
	@foreach($anag->gg_fuori_sede()->get() as $row)
		<tr>
			<td>{{ $row->id }}</td>
			<td>{{ $row->q3desc }} - {{ $row->q3tipo }}</td>
			<td>{{ $row->q3pro }}</td>
			<td>{{ $row->categoria_eco }}</td>
			<td>{{ $row->q3fun }}</td>
			<td>{{ $row->q32kd }}</td>
			<td>{{ $row->q32ka }}</td>
			@php
				$curr=	$row->gg(['date_max'=>$date_max,'date_min'=>$date_min
								//,'propro'=>$scheda->propro
								,'categoria_eco'=>$scheda->categoria_ecoval
								,'posfun'=>$scheda->posfun]);
				$tot+=$curr;
			@endphp
			<td align="right">{{ $curr }}</td>
		</tr>
	@endforeach
	--}}
		<tr><th colspan="7">TOT</th><td align="right"><b>{{ $tot }}</b></td></tr>
</tbody>
</table>