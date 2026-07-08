ude($view.'.style')
<page style="font-size: 10pt">
@include($view.'.head')
<h4 style="text-align:center;">{!! trans('progressioni::MaxCatecoPosfunAnno.'.$anno.'.riga1') !!}</h4>
<h3 style="text-align:center;">{!! trans('progressioni::MaxCatecoPosfunAnno.'.$anno.'.riga2') !!}</h3>
<h5 style="text-align:center;">{!! trans('progressioni::MaxCatecoPosfunAnno.'.$anno.'.riga3') !!}</h5>
<b>
<br/>CATEGORIA GIURIDICA: {{ $cat->categoria_ecoval }}
<br/>PERCORSO PROFESSIONALE DA {{ $cat->categoria_ecoval }}-{{ $cat->posfunval }} A {{ $cat->categoria_ecoval }}-{{ $cat->posfunval+1 }}
<br/>PARTECIPANTI : {{ count($rows) }}
<br/>AVENTI DIRITTO : {{ $cat->aventi_diritto_eff }}
</b>
<br/><br/>
<table class="table table-striped table-bordered">
	<thead>
		<tr><td><b>N. PROGR.</b></td><td><b>DIPENDENTE</b></td><td><b>PUNTEGGIO</b></td><td><b>IDONEO</b></td></tr>
	</thead>
@foreach($rows as $k=>$row)

@php
	$k=$loop->index;
@endphp
<tr>
	<td align="center">{{ $k+1 }}</td>
	<td>{{ $row['matr'] }} - {{ $row['cognome'] }} {{ $row['nome'] }}</td>
	<td align="right">{{ number_format($row['risultato'],3) }}</td>
	<td align="center">@if($k<$cat->aventi_diritto_eff) <b>X</b> @endif</td>
</tr>
@endforeach
</table>
@include($view.'.firma')
<hr/>
NOTA: AI SENSI DELL'ARTICOLO 32 DEL CCDI DEL 22.10.2013 AVVERSO ALLA PRESENTE GRADUATORIA E' AMMESSO RICORSO MOTIVATO ENTRO 10 GIORNI DALLA DATA DI PUBBLICAZIONE SULL'ALBO PRETORIO E SUL SITO ISTITUZIONALE.
</page>