nds('pub_theme::layouts.app')
@section('content')
<x-filament::badge> flash-message </x-filament::badge>

<h3>
date min : {{ $date_min }} <br/>
date max : {{ $date_max }} <br/>
lista codice aspettative {{ $lista_codici_aspettative }}
</h3>
@include($view.'.head')

@php
	$row=$schede->first();
	if($row==null){
		echo '<h3>Matricola non presente</h3>';
		return ;
	}
@endphp

@foreach($row->coeff()->get() as $kc=>$vc)
	@php
		$sk=$vc->name;
	@endphp
	@if($vc->value!=0 )
		<h3>{{ $sk }}</h3>
		@include('progressioni::admin.ctrlmatr.'.$sk,['anag'=>$anag,'lista_codici_aspettative'=>$lista_codici_aspettative])
	@endif
@endforeach

<hr/><hr/><hr/><hr/><hr/><hr/><hr/><hr/>

@endsection
