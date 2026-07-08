	//$route=performance.stabi_repar_anno_individuale.index
	$stabi=null;$repar=null;$firma=null;
	extract($params);
	if(isset($rows[0]) ) {
		$firma=$rows[0]->stabi_dirigente;
		$stabi=$rows[0]->stabi;
		$repar=$rows[0]->repar;
	}
	$firma_route=str_replace('.index','.firma',$routename);
	$firma_route_href=route($firma_route,$params);
@endphp
{{-- $firma_route_href
{{ $params['stabi'] }} {{ $params['repar'] }}
--}}
@if($firma!=null)
{{-- Form::model($firma, ['route'=>[$firma_route,array_values($params)] ]) --}}
<form method="POST" action="{{ $firma_route_href }}">
{{ csrf_field() }}
{{ method_field('PUT') }}
{{ Form::bsText('nome_stabi',$firma->nome_stabi) }}
{{ Form::bsText('nome_diri',$firma->nome_diri) }}
{{ Form::hidden('stabi',$stabi) }}
{{ Form::hidden('repar',$repar) }}
{{ Form::hidden('anno',$params['anno']) }}
{{Form::submit('modifica firma',['class'=>'submit btn btn-success green-meadow'])}}
{{ Form::close() }}

<hr/>

@endif


{{-- $routename --}}