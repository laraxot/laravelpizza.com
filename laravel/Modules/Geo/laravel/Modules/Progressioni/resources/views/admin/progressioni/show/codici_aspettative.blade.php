odici Aspettative [codici_assenze_progressione]</h2>
<table class="table table-striped table-bordered ">
<thead>
	<tr>
		<td>[id]</td>
		<td>tipo</td>
		<td>codice</td>
		<td>descr</td>
	</tr>
</thead>
<tbody>
	@foreach($criteri->codiciAspettative()->get() as $row)
	<tr>
		<td>[{{ $row->id }}]</td>
		<td>{{ $row->tipo }}</td>
		<td>{{ $row->codice }}</td>
		<td>{{ $row->descr() }}</td>
	</tr>
	@endforeach
</tbody>
</table>