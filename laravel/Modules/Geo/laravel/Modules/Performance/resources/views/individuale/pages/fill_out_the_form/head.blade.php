<table class="table">
	<tr>
		<td>ID</td>
		<td> {{ $record->id }} </td>
	</tr>
	<tr>
		
		<td>Lavoratore</td>
		<td>{{ $record->ente }}-{{ $record->matr }} <br/>
			{{ $record->cognome }} {{ $record->nome }} <br/>
		</td>
	</tr>
	<tr>
		<td>Qualifica</td>
		<td>{{ $record->propro }}-{{ $record->posfun }} <br/>
			{{ $record->categoria_eco }} {{ $record->posfun }}
		</td>
	</tr>
    {{--
	<tr>
		<td>Titolo di Studio</td>
		<td> {{ $record->titolo_di_studio }} </td>
	</tr>
	
	<tr>
		<td>ptime</td>
		<td>{{ $record->ptime }}</td>
	</tr>
     
	<tr>
		<td>Valore differenziale (rapportato a pt)</td>
		<td> {{ $row->costo_fascia_up * $row->ptime }} </td>
	</tr>
	<tr>
		<td>Importo Stipendio Annuo (tabellare)</td>
		<td> {{ $row->importo_stipendio_annuo }}</td>
	</tr>
	--}}
</table>
