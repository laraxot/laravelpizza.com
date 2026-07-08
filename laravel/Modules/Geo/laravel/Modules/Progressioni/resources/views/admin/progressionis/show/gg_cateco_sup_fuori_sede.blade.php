iorni categoria eco <b>SUPERIORE</b> fuori sede [qua03f]</h2>
<h3>lista propro: {{ $scheda->lista_propro }}</h3>
<h3>lista propro_sup: {{ $scheda->lista_propro_sup }}</h3>
<table class="table table-striped table-bordered ">
<thead>
	<tr>
		<td>id</td>
		<td>descr</td>
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
	@foreach($anag->qua03f()->get() as $row)
		<tr>
			<td>{{ $row->id }}</td>
			<td>{{ $row->q3desc }}</td>
			<td>{{ $row->q3pro }} {{--  - {{ $row->q3tipo }} --}}</td>
			<td>{{ $row->categoria_eco }} </td>
			<td>{{ $row->q3fun }}</td>
			<td>{{ $row->q32kd }}</td>
			<td>{{ $row->q32ka }}</td>
			@php
				$curr=	$row->gg(['date_max'=>$date_max,
								  'date_min'=>$date_min,
								  //'propro'=>$schede->first()->propro
								  //'categoria_eco'=>$schede->first()->categoria_ecoval
								  'lista_propro'=>$scheda->lista_propro_sup,
								  ]);
				$tot+=$curr;
			@endphp
			<td align="right">{{ $curr }}</td>
		</tr>
	@endforeach
		<tr><th colspan="7">TOT</th><td align="right"><b>{{ $tot }}</b></td></tr>
</tbody>
</table>
