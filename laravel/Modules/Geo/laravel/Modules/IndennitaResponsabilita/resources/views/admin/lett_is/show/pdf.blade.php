e type="text/css">
<!--


table.morpion
{
	border: solid 1px #000000;
	width: 90%;
 }}

table.morpion th
{
	font-size:		8pt;
	font-weight:	bold;
	border-left:			solid 1px #000000;
	border-bottom:			solid 1px #000000;
	padding:		1px;
	text-align:		center;
 }}



table.morpion td
{
	font-size:		8pt;
	border:			solid 1px #000000;
	border-left:			solid 1px #000000;
	border-bottom:			solid 1px #000000;
	text-align:		center;
 }}

table.morpion td.j1 { color: #0A0;  }}
table.morpion td.j2 { color: #A00;  }}

.alt{
	background-color:#C0F0C0;
 }}




-->
</style>
<page backtop="20mm" backbottom="10mm" backleft="5mm" backright="5mm">
	<page_header>
		@include('ptv::intestazione')
	</page_header>
	{{--
<img src="{{ Theme::img_src('ptv::img/logo_ptv70px.gif') }} " alt="" style="height:70px;" height="70px">
<h3 style="text-align:center;">
Scheda di attribuzione indennit&aacute; di responsabilit&aacute; (art.17, comma 2, lett.I) ccnl 1.4.1999 - Anno {{ $row->anno }}
</h3>
	--}}
@php
		$msg=$row->messages->keyBy('type');
	@endphp
<h3 style="text-align:center;">
			{!! nl2br($msg['responsabilita_i_su']->txt) !!}
			{{--
				Scheda di attribuzione indennit&aacute; di responsabilit&aacute; (art.17, comma 2, lett.f) ccnl 1.4.1999) - Anno {{ $row->anno}}
			--}}
</h3>
<br/>
<b>Dipendente:</b> {{ $row->cognome }} {{ $row->nome }} <b>matr:</b> {{ $row->matr }} <b>Cat. Giur:</b> {{  $row->categoria_eco }}<br/>
<b>Settore:</b> {{ $row->stabi_txt }} <b>Reparto:</b> {{ $row->repar_txt }}
<br/><b>Dal:</b>{{ $row->dali->format('d/m/Y') }} <b>Al:</b>{{ $row->ali->format('d/m/Y') }}
<br/><br/>

<table class="morpion" align="center">
	<tr>
		<th style="width:10%">Descrizione attivit&aacute;</th>
		<th style="width:30%">Descrizione posizione di lavoro e responsabilit&aacute;</th>
		<th style="width:50%">Posizione ricoperta dal dipendente (<i>da segnalare specificando il contenuto dell'attivit&aacute; svolta</i>)</th>
	</tr>
	<tr>
		<th>Archivista informatico</th>
		<td  style="width:30%">Responsabilit&aacute; diretta di organizzazione dei dati e della documentazione da archiviare</td>
		<td style="width:50%">{{ $row->archivista_informatico }}</td>
	</tr>
	<tr>
		<th>Addetto Ufficio Relazioni con pubblico</th>
		<td  style="width:30%">Organizzazione del front office nel rapporto con l'utenza e relativo orientamento</td>
		<td style="width:50%">{{ $row->relazioni_pubblico }}</td>
	</tr>
	<tr>
		<th>Addetto alla protezione civile</th>
		<td  style="width:30%">Responsabilit&aacute; diretta di organizzazione di interventi di protezione civile.</td>
		<td style="width:50%">{{ $row->protezione_civile }}</td>
	</tr>
	<tr>
		<th>Formatore Professionale</th>
		<td  style="width:30%">Responsabilit&aacute; di gruppi di processi informativi rivolti al personale interno</td>
		<td style="width:50%">{{ $row->formatore_professionale }}</td>
	</tr>

</table>
<br/><br/><br/>
<table style="width:100%;">
	<tr>
		<td style="width:33%;font-size:12pt;">Data
		<br/> {{ $row->updated_at->format('d/m/Y') }}</td>
		<td style="width:66%;font-size:12pt;">IL DIRIGENTE DI SETTORE
		<br/><b>{{ $row->stabi_dirigente->nome_diri }}</b>
		<br/>_____________________________</td>

	</tr>
</table>
<p>
	{!! nl2br($msg['responsabilita_i_giu']->txt) !!}
</p>
</page>





