nds('adm_theme::layouts.app')
@section('page_heading','Valutazione')

@section('section')
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

{!! Form::bsBtnBack('edit') !!}
{!! Form::bsOpen($row,'update') !!}
<hr/>
<b>Dipendente:</b> {{$row->cognome}} {{$row->nome}} <b>matr:</b> {{$row->matr}} <b>Cat. Giur:</b> {{$row->categoria_eco }} <br/>
<b>Settore:</b> {{$row->stabi_txt}} <b>Reparto:</b> {{$row->repar_txt}}
<br/>
<pre>
i decimali vanno scritti con il "."
inserire valori da 0 a 10
</pre>
{{ Form::bsText('email') }}
<br style="clear:both" />
<br style="clear:both" />

{{-- <b>dal:</b> {{ $row->dal }} <b>al:</b> {{ $row->al }} --}}
<table class="table table-striped table-bordered " >
<thead>
	<tr>
		<td>criterio</td>
		<td>valore</td>
		<td>peso %</td>
		<td></td>
	</tr>
</thead>

@foreach($row->valutaz_fields as $field)
<tr>
	<td>{!! trans('progressioni::schede.'.$field.'_long') !!}</td>
	@if($field=='esperienza_acquisita')
	<td align="right"><div id="{{ $field }}">{{  $row->$field }}</div></td>
	@else
	<td align="right">{{ Form::bsText($field) }}</td>
	@endif
	@php
	 	$peso_field='peso_'.$field;
	@endphp
	<td align="right"><div id="{{ $peso_field }}">{{ $row->$peso_field }}</div></td>
	<td><div id="tot_{{ $field }}"></div></td>
</tr>
@endforeach
<tr><td colspan="3"><b>Tot</b></td><td><div id="tot" style="color:darkblue;font-weight:800;"></div>
{{ Form::hidden('totale') }}
</td></tr>
<tr>
	<td colspan="4" align="center">{{ Form::bsSubmit('Conferma !') }}</td>
</tr>
</table>

{{ Form::close() }}


<br style="clear:both" />
<br style="clear:both" />
<br style="clear:both" />
<br style="clear:both" />
<br style="clear:both" />
@endsection

@push('scripts')
<script>
function aggiornaTot(){
	var elements = $("input:text") ;
	var tot = 0;
	v=$( "#esperienza_acquisita").text();
	v=parseFloat(v);
	vp=$( "#peso_esperienza_acquisita").text();
	vp=parseFloat(vp);
	num=v*vp/100;
	num=num.toFixed(3);
	$( "#tot_esperienza_acquisita").text(num);
	tot= tot + parseFloat(num);
	//----------
	v=$( "input[name='risultati_ottenuti']").val();
	v=parseFloat(v);
	vp=$( "#peso_risultati_ottenuti").text();
	vp=parseFloat(vp);
	num=v*vp/100;
	num=num.toFixed(3);
	$( "#tot_risultati_ottenuti").text(num);
	tot= tot + parseFloat(num);
	//----------
	v=$( "input[name='arricchimento_professionale']").val();
	v=parseFloat(v);
	vp=$( "#peso_arricchimento_professionale").text();
	vp=parseFloat(vp);
	num=v*vp/100;
	num=num.toFixed(3);
	$( "#tot_arricchimento_professionale").text(num);
	tot= tot + parseFloat(num);
	//----------
	v=$( "input[name='impegno']").val();
	v=parseFloat(v);
	vp=$( "#peso_impegno").text();
	vp=parseFloat(vp);
	num=v*vp/100;
	num=num.toFixed(3);
	$( "#tot_impegno").text(num);
	tot= tot + parseFloat(num);
	//----------
	v=$( "input[name='qualita_prestazione']").val();
	v=parseFloat(v);
	vp=$( "#peso_qualita_prestazione").text();
	vp=parseFloat(vp);
	num=v*vp/100;
	num=num.toFixed(3);
	$( "#tot_qualita_prestazione").text(num);
	tot= tot + parseFloat(num);
	//----------

	//tot=tot.toFixed(2);
	$('#tot').html(tot.toFixed(3));
	$( "input[name='totale']").val(tot);

}


$("input:text").on("keyup", function(e) {
	//alert($(this).val());
	aggiornaTot();
});
aggiornaTot();

</script>

@endpush
