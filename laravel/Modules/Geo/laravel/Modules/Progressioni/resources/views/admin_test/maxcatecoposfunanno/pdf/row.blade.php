ude($view.'.style')
<page style="font-size: 10pt">

@include($view.'.head',['row'=>$row])
<h4 style="text-align:center;">{!! trans('progressioni::MaxCatecoPosfunAnno.riga1') !!}</h4>
<h3 style="text-align:center;">{!! trans('progressioni::MaxCatecoPosfunAnno.riga2') !!}</h3>
<h5 style="text-align:center;">{!! trans('progressioni::MaxCatecoPosfunAnno.riga3') !!}</h5>
@php
	$rows=$row->schede();
	$rows0=$rows->distinct()->where('ha_diritto',1)->orderBy('totale_pond','desc')->where('totale','>',0)->groupBy('matr');
@endphp
<b>
<br/>CATEGORIA GIURIDICA: {{ $row->cateco }}
<br/>PERCORSO PROFESIONALE DA {{ $row->cateco }}-{{ $row->posfun }} A {{ $row->cateco }}-{{ $row->posfun+1 }}
<br/>PARTECIPANTI : {{ count($rows0->get()->toArray()) }}
<br/>AVENTI DIRITTO : {{ $row->aventi_diritto_eff }}
</b>
<br/><br/>
<table class="table table-striped table-bordered">
	<thead>
		<tr><td><b>N. PROGR.</b></td><td><b>DIPENDENTE</b></td><td><b>PUNTEGGIO</b></td><td><b>IDONEO</b></td></tr>
	</thead>
@foreach($rows0->get() as $k=>$row0)
<tr>
	<td align="center">{{ $k+1 }}</td>
	<td>{{ $row0->matr }} - {{ $row0->cognome }} {{ $row0->nome }}</td>
	<td align="right">{{ number_format($row0->totale_pond,3) }}</td>
	<td align="center">@if($k<$row->aventi_diritto_eff) <b>X</b> @endif </td>
</tr>
@endforeach
</table>



@include($view.'.firma',['row'=>$row])

<hr/>
NOTA: AI SENSI DELL'ARTICOLO 32 DEL CCDI DEL 22.10.2013 AVVERSO ALLA PRESENTE GRADUATORIA E' AMMESSO RICORSO MOTIVATO ENTRO 10 GIORNI DALLA DATA DI PUBBLICAZIONE SULL'ALBO PRETORIO E SUL SITO ISTITUZIONALE.
</page>