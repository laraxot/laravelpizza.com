<table class="table">
	<tr>
		<td>Lavoratore</td>
		<td>{{ $row->ente }}-{{ $row->matr }} <br/>
			{{ $row->cognome }} {{ $row->nome }} <br/>
		</td>
	</tr>
	<tr>
		<td>Qualifica</td>
		<td>{{ $row->propro }}-{{ $row->posfun }} <br/>
			{{ $row->categoria_eco }} {{ $row->posfun }}
		</td>
	</tr>
	<tr>
		<td>Titolo di Studio</td>
		<td> {{ $row->titolo_di_studio }} </td>
	</tr>
	{{--
	<tr>
		<td>ptime</td>
		<td>{{ $row->ptime }}</td>
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
