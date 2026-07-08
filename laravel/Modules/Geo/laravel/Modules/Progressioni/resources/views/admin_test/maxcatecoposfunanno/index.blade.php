nds('adm_theme::layouts.app')
@section('page_heading','Max Cateco posfun ')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


{{-- Form::bsYearNav(['routename'=>'progressioni.anno_pesi.index']) --}}
{{--   Form::bsBtnCreate() --}}
@include($view.'.nav')
@include($view.'.firma')
{{-- $params['anno'] --}}
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
	<td></td>
</tr>
</thead>
<tbody>
@php
	$tot=0;
	$tot_eff=0;
@endphp
@foreach($allrows->orderBy('cateco')->orderBy('posfun')->get() as $k =>$v)
<tr>
	<td>{{ $v->id }}</td>
	<td>{{ $v->cateco }}</td>
	<td>{{ $v->posfun }}</td>
	<td>{{ $v->max_gg_tot_pond }}</td>
	<td>{{ $v->anno }}</td>
	<td align="right">{{ $v->aventi_diritto }}</td>
	<td  align="right">{{ $v->aventi_diritto_perc }}</td>
	<td  align="right">{{ $v->aventi_diritto_eff }}</td>
	<td>{!!  Form::bsBtnEdit(['id_maxCatecoPosfunAnno'=>$v->id]) !!}</td>
</tr>
@php
	$tot+=$v->aventi_diritto;
	$tot_eff+=$v->aventi_diritto_eff;
@endphp
@endforeach
</tbody>
<tr><td colspan="5"><b>Tot</b></td>
	<td align="right"><b>{{ $tot }}</b></td>
	<td></td>
	<td align="right"><b>{{ $tot_eff }}</b></td>
	<td></td>
</tr>
</table>
@endsection
