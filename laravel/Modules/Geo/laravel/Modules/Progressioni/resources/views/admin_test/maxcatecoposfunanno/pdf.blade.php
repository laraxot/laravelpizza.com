ude($view.'.style')
<page style="font-size: 10pt">

@include($view.'.head',['row'=>$rows->get()[0]])

<table class="table table-striped table-bordered">
<thead>
<tr>
	<td>[ID]</td>
	<td>cateco</td>
	<td>posfun</td>
	<td>max_gg_tot_pond</td>
	<td>anno</td>
	<td>N dipendenti aventi diritto</td>
	<td>percentuale aventi diritto</td>
	<td>aventi diritto effettivi</td>

</tr>
</thead>

@php
	$tot=0;
	$tot_eff=0;
@endphp
@foreach($rows->orderBy('cateco')->orderBy('posfun')->get() as $k =>$v)
<tr>
	<td>{{ $v->id }}</td>
	<td>{{ $v->cateco }}</td>
	<td>{{ $v->posfun }}</td>
	<td align="right">{{ $v->max_gg_tot_pond }}</td>
	<td>{{ $v->anno }}</td>
	<td align="right">{{ $v->aventi_diritto }}</td>
	<td align="right">{{ $v->aventi_diritto_perc }}</td>
	<td align="right">{{ $v->aventi_diritto_eff }}</td>

</tr>
@php
	$tot+=$v->aventi_diritto;
	$tot_eff+=$v->aventi_diritto_eff;
@endphp
@endforeach

<tr>
	<td colspan="5"><b>Tot</b></td>
	<td align="right"><b>{{ $tot }}</b></td>
	<td></td>
	<td align="right"><b>{{ $tot_eff }}</b></td>
	<td></td>
</tr>
</table>

{{--
@include($view.'.firma',['row'=>$rows->get()[0]])
--}}
</page>