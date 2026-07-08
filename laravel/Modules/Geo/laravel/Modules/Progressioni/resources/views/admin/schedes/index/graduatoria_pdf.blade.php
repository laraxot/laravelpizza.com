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
	font-size: 10pt;
	padding:4px;
	/*height:12px;
	*/
	padding:2px;
}

table.morpion th{
	border-top:				solid 1px #000000;
	border-left:			solid 1px #000000;
	border-bottom:			solid 1px #000000;
	text-align:		center;
	valign:top;
	font-size: 11pt;
	height:40px;
	padding:4px;
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

<page backtop="23mm">
	<page_header>
		@include('ptv::intestazione')
	</page_header>
	@foreach($rows as $row)
		@if($loop->first)
			@php
				$msg=$row->messages->keyBy('type');
			@endphp
			<h3>
			{!! nl2br($msg['graduatoria_su']->txt) !!}
			<br />
			{{ $row->valutatore->nome_stabi }}
			</h3>
			<table class="table morpion">
			<thead>
				<tr>
					<th colspan="5">Categoria Giuridica: {{ $row->categoria_eco }}</th>
				</tr>
				<tr>
				<th>N</th>
				<th>Matr</th>
				<th>Lavoratore</th>
				<th>Punteggio</th>
				<th>Beneficiario</th>
				</tr>
			</thead>
		@endif
		<tr>
			<td>{{ $loop->index+1 }}{{-- $row->posizione --}}</td>
			<td>{{ $row->matr }}</td>
			<td>{{ $row->cognome }} {{ $row->nome }}</td>
			<td align="right">{{ number_format($row->punt_progressione_finale,2) }}</td>
			<td align="center">
				@if($row->benificiario_progressione)
					X
				@endif
			</td>
			{{--
			<td>{{ $row->valutatore_id }}</td>
			--}}
		</tr>
		@if($loop->last)
			</table>
			<h5>
			{!! nl2br($msg['graduatoria_giu']->txt) !!}
			</h5>
		@endif
	@endforeach
</page>
