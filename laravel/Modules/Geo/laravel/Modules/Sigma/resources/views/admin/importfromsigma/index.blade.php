nds('adm_theme::layouts.app')
@section('page_heading','package sigma')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>



{!! Form::bsFormSearch() !!}
<p>Prima di fare le importazioni controllare se la password e' scaduta in nemho entrando con il profilo PTV_XOTT, se scaduta dopo aver cambiato la password aggiornarla anche dentro  il programma settings (backend nella toolbar >>settings icona in mezzo ) >>settings(colonna a sx)>>config file(menu tendina sotto settings nella colonna a sx)" e selezionare sigma(in centro in alto) e mettere nel campo password la password aggiornata e poi cliccare su salva.<br/>
se le tabelle ancora non si scaricano collegarsi a <a href="https://sigtransfer.sigmapaghe.com/" target='_blank'>https://sigtransfer.sigmapaghe.com/</a>
e verificare se con l'utente PTV_XOTT si entri correttamente.
<br/><b>PS</b>
<ul>
<li> Se viene fuori la scritta "file caricato male" si puo' provare a schiacciare il tasto "f5" della tastiera </li>
<li> Se non si riesce ad entrare in sigtransfer, e' inutile cercare di scaricare le tabelle </li>
<li> Se in sigtransfer viene scritto qualcosa in rosso, leggerlo, probabilmente bisogna "normalizzare" l'utente perche' si e' provato piu' di 3 volte con una password sbagliata.</li>
<li> Se c'e' urgenza di stampare delle trasferte andare sul programma trasferte >> trasferte admin (colonna a sx) >> crea file txt di tutte le trasferte ed invialo (menu a tendina sotto trasferte admin nella colonna a sx) >> poi cliccare sul checkbox conferma e poi sul tasto vai (in mezzo allo schermo)</li>
</ul>
</p>

<table class="table table-hover table-condensed table-responsive table-striped">
<thead>
	<tr>
		<td>ID</td>
		<td>DB.TBL</td>
		<td>descr</td>
		<td>num records</td>
		<td>ultimo aggiornamento</td>
		<td>aggiornato da</td>
		<td></td>
	</tr>
</thead>
@foreach($rows as $row)
<tr>
	<td>{{ $row->id }}</td>
	<td>{{ $row->db }}.{{ $row->tbl }}</td>
	<td>{{ $row->descr }}</td>
	<td>{{ $row->n_rows }}</td>

	<td>{{ $row->updated_at }}</td>
	<td>{{ $row->updated_by }}</td>

	<td>{!! Form::bsBtnEdit(['id_importFromSigma'=>$row->id]) !!}</td>
</tr>
@endforeach
</table>
{{ $rows->links() }}
@endsection
