e type="text/css">
table.morpion{
	border-right:		solid 1px #444444;
}

table.morpion tr{
	border-bottom:			solid 1px #000000;
}

table.morpion td{
	border-left:			solid 1px #000000;
	border-bottom:			solid 1px #000000;
	text-align:		left;
	valign:top;
	font-size: 8pt;
	/*height:12px;
	*/
	padding:2px;
}

table.morpion th{
	border-left:			solid 1px #000000;
	border-bottom:			solid 1px #000000;
	text-align:		left;
	valign:top;
	font-size: 8pt;
	height:40px;
}

td.verticale{
    writing-mode: tb-rl;
    filter: flipv fliph;
}
.alt{
	background-color:#C0F0C0;
}

.rot{
	rotate:90;
	text-align:center;
	height:100%;
	width:100%;
	padding: 0px;

}

.thead {
	width:30px;
	text-align:center;
	vertical-align:middle;

}
</style>
<page>
@include('ptv::intestazione')
<h3>
	@php
		$title=$opzioni->where('name','title_condizioni_lavoro')->first(null,['value'=>'impostare su opzioni'])['value'];
		$title=str_replace('#anno#',$anno,$title);
		$title=str_replace('#trimestre#',\Request::input('trimestre'),$title);
	@endphp
	{{ $title }}<br/>
	{{ $firma->nome_stabi }}
</h3>
<table class="table morpion" style="width:100%">
	<col style="width: 10%;" />
	<col style="width: 7%" />
	<col style="width: 82%" />
	<thead>
		<tr>
			<td>Lavoratore</td>
			<td>Dal<br/>Al</td>
			<td> </td>
		</tr>
	</thead>
@foreach($rows as $row)
<tr>
	<td>{{ $row->id }}]<br/>
		{{ $row->ente }}-{{ $row->matr }}<br/>
		{{ $row->cognome }} {{ $row->nome }} <br/>
		part time: {{ number_format($row->perc_p_time_daterange*100,2) }}%
	</td>
	<td>{{ $row->dal->format('d/m/Y') }}<br/>{{ $row->al->format('d/m/Y') }}</td>
	<td>
		<table class="table " style="width:100%">
			<col style="width: 10%;" />
	 		<col style="width: 75%" />
	 		<col style="width: 5%" />
	 		<col style="width: 5%" />
	 		<col style="width: 5%" />
			<thead>
				<tr>
					<td>Tipo</td>
					<td>Descrizione</td>
					<td>&euro; al giorno</td>
					<td>Giorni</td>
					<td>Tot </td>

				</tr>
			</thead>
		@foreach($row->indennitaTipoDettaglio as $row0)
		@if($row0->pivot->gg>0)
		<tr>
			<td><b>{{ $row0->indennitaTipo->nome }}</b></td>
			<td>{{ $row0->nome }}</td>
			<td align="right">{{ $row0->euro_giorno }}</td>
			<td align="right">{{ $row0->pivot->gg }}</td>
			<td align="right"><b>{{ $row0->pivot->tot }}</b></td>
		</tr>
		@endif
		@endforeach
		{{--
		<tr>
			<td colspan="5">
				<hr/>
			</td>
		</tr>
		--}}
		<tr>
			<td colspan="4" align="right">
				TOT &euro;
			</td>
			<td align="right"><b>{{ $row->tot }}</b></td>
		</tr>
		<tr>
			<td colspan="4" align="right">
				TOT x Part-Time &euro;
			</td>
			<td align="right"><b>{{ number_format($row->tot_x_ptime,2) }}</b></td>
		</tr>

		</table>
	</td>

</tr>
@endforeach
</table>
@include('ptv::firma')
</page>