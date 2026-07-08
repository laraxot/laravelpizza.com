e>
	@foreach($rows as $i=>$tbl)
		@php
			$data=collect($tbl->toArray())->except(['datemod','created_at'])->all();
		@endphp
		@if($i==0)
			<tr>
				<td>N</td>
				@foreach($data as $k=>$v)
					<td>{{ $k }}</td>
				@endforeach
			</tr>
		@endif
		<tr>
			<td>[{{ $i }}]</td>
			@foreach($data as $k=>$v)
				<td>{{ $v }}</td>
			@endforeach
		</tr>
	@endforeach
</table>