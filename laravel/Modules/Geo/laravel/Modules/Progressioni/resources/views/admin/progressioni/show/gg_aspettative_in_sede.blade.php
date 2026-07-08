iorni Aspettative In Sede[asz00k1 &amp; codici_assenze_progressione]</h2>
<table class="table table-striped table-bordered ">
<thead>
	<tr>
		<th>id</th>
		<th>tipo</th>
		<th>codice</th>
		<th>dal</th>
		<th>al</th>
		<th>gg</th>
	</tr>
</thead>
<tbody>
@php
	$tot=0;
	$tot_pond=0;
@endphp
{{--
@foreach($criteri->codiciAspettative()->get() as $codiceasp)
@foreach($codiceasp->asz00k1()->orderBy('asz2kd')->get() as $row)
--}}
@foreach($schede->first()->asz00k1()->orderBy('asz2kd')->get() as $row)
	<tr>
		<td>{{ $row->id }}</td>
		<td>{{ $row->asztip }}</td>
		<td>{{ $row->aszcod }}</td>
		<td>{{ $row->asz2kd }}</td>
		<td>{{ $row->asz2ka }}</td>
		@php
			$curr=	$row->gg(['date_max'=>$date_max,'date_min'=>$date_min]);
			$tot+=$curr;
		@endphp
		<td align="right">{{ $curr }}</td>
	</tr>
@endforeach
{{--
@endforeach
@endforeach
--}}
<tr>
	<td colspan="5"><b>Tot</b></td>
	<td align="right"><b>{{ $tot }}</b></td>
</tr>
</tbody>
</table>