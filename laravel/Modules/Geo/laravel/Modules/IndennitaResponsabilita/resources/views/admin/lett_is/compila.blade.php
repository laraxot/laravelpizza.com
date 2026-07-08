nds('adm_theme::layouts.app')
@section('page_heading','Modifica Resposabilita Lett I')

@section('content')
<x-filament::badge> flash-message </x-filament::badge>

<style>
table label{
	display:none;
}
table input[type='text'] {
	width:100px;
	text-align: right;
}

table tr td div {
	/*width:100%;*/

}
table tr td div div.col-md-6{
	width:100%;

}

</style>
{{--
{!! Form::bsBtnBack('edit') !!}
--}}
<a href="{{ Panel::make()->get($row)->url('index') }}" class="btn btn-primary">&laquo; Torna alla lista </a>
{!! Form::bsOpen($row,'update') !!}

<h3 style="text-align:center;">
Scheda di attribuzione indennità di responsabilità (art.17, comma 2, lett.I) ccnl 1.4.1999 - Anno {{ $row->anno }}
</h3>
<br/>

<b>Dipendente:</b> {{ $row->cognome}} {{  $row->nome }} <b>matr:</b> {{ $row->matr}} <b>Cat. Giur:</b> {{  $row->categoria_eco }}  <br/>
<br style="clear:both" />
<b>Settore:</b> {{ $row->stabi_txt }} <b>Reparto:</b> {{ $row->repar_txt }}
{{--
<br/>{{ Form::bsDateRange('dali','ali') }}
--}}
<div class="row">
	<div class="col-md-3">
		{{ Form::bsDate('dali') }}
	</div>
	<div class="col-md-3">
		{{ Form::bsDate('ali') }}
	</div>
</div>


{{ Form::bsText('email') }}<br/><br/>
<br style="clear:both"/>

<table border="1">

	<tr>
		<th>Descrizione attività</th>
		<th>Descrizione posizione di lavoro e responsabilità</th>
		<th>Posizione ricoperta dal dipendente (<i>da segnalare specificando il contenuto dell'attività svolta</i>)</th>
	</tr>
	<tr>
		<th>Archivista informatico</th>
		<td>Responsabilità diretta di organizzazione dei dati e della documentazione da archiviare</td>
		<td >{{ Form::bsTextarea('archivista_informatico') }}</td>
	</tr>
	<tr>
		<th>Addetto Ufficio Relazioni con pubblico</th>
		<td>Organizzazione del front office nel rapporto con l'utenza e relativo orientamento</td>
		<td >{{ Form::bsTextarea('relazioni_pubblico') }}</td>
	</tr>
	<tr>
		<th>Addetto alla protezione civile</th>
		<td>Responsabilità diretta di organizzazione di interventi di protezione civile.</td>
		<td >{{ Form::bsTextarea('protezione_civile') }}</td>
	</tr>
	<tr>
		<th>Formatore Professionale</th>
		<td>Responsabilità di gruppi di processi informativi rivolti al personale interno</td>
		<td >{{ Form::bsTextarea('formatore_professionale') }}</td>
	</tr>


	<tr><td colspan="4" align="center">{{ Form::bsSubmit('salva') }}</td></tr>

</table>
{{ Form::close() }}

<br style="clear:both" />
<br style="clear:both" />
<br style="clear:both" />
<br style="clear:both" />
<br style="clear:both" />

@endsection
