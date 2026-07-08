<br/><br/>
<table style="width:100%;border:0px white;">
	<tr>
		<td style="width:33%;font-size:12pt;">Data
		@if(isset($row) && $row instanceOf \Carbon\Carbon)
		<br/> {{ $row->updated_at->format('d/m/Y') }}
		@else
		<br/> {{ \Carbon\Carbon::now()->format('d/m/Y') }}
		@endif
		</td>

		<td style="width:66%;font-size:12pt;">IL DIRIGENTE DI SETTORE
		<br/><b>{{ $firma }}</b>
		<br/>_____________________________</td>
	</tr>
</table>