<table>
	<tr>
		<td>
			IL DIRIGENTE <br/><b>{{ $row->valutatore->nome_diri }}</b>
		</td>
		<td>&nbsp;&nbsp;&nbsp;
		</td>
		<td>
			Treviso, <br/>{{ \Carbon\Carbon::now()->format('d/m/Y') }}
		</td>
	</tr>
</table>