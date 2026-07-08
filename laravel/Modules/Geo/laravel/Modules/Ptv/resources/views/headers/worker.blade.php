e cellspacing="0" class="data table table-striped table-bordered">
<tr><th>MATR. DIPENDENTE</th><td>{{ $anag->matr }}</td></tr>
<tr class="alt"><th>DIPENDENTE </th><td>{{ $anag->conome }} {{ $anag->nome }}</td></tr>

@foreach($anag->Rep00f(['in_mese'=>$params['mese'],'in_anno'=>$params['anno']]) as $k_rep => $v_rep)
	<tr><th>Settore</th><td>{{ $v_rep->stabi['dest1'] }} </td></tr>
	<tr class="alt"><th></th><td>{{ $v_rep->repart['dest1'] }}</td></tr>
@endforeach

@foreach($anag->Qua00f(['in_mese'=>$params['mese'],'in_anno'=>$params['anno']]) as $k_qua => $v_qua)
	<tr><th>Pos Economica</th><td>{{ str_replace('Posizione economica ','',$v_qua->tqu00f['desc1']) }}<br/>{{ $v_qua->tqu00f['desc2'] }}</td></tr>
@endforeach
{{--
@foreach($anag->Ana02f(['in_mese'=>$params['mese'],'in_anno'=>$params['anno']]) as $k_ana => $v_ana)
	<tr><th>Residenza</th><td>
	{{ $v_ana->topo }} {{ $v_ana->indir }}  {{ $v_ana->locres }}</td></tr>
@endforeach
--}}
</table>