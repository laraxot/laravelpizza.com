	//progressioni.anno_maxcatecoposfunanno.firma
	$firma_route=str_replace('.index','.firma',$routename);
	$firma_route_href=route($firma_route,$params);
@endphp
{{ $routename }}
<form method="POST" action="{{ $firma_route_href }}">
{{ csrf_field() }}
{{ method_field('PUT') }}
{{ Form::bsText('riga1',trans('progressioni::MaxCatecoPosfunAnno.'.$anno.'.riga1')) }}
{{ Form::bsText('riga2',trans('progressioni::MaxCatecoPosfunAnno.'.$anno.'.riga2')) }}
{{ Form::bsText('riga3',trans('progressioni::MaxCatecoPosfunAnno.'.$anno.'.riga3')) }}
{{ Form::bsText('nome_diri',trans('progressioni::MaxCatecoPosfunAnno.'.$anno.'.nome_diri')) }}
{{ Form::bsText('data_firma',trans('progressioni::MaxCatecoPosfunAnno.'.$anno.'.data_firma')) }}
{{Form::bsSubmit('modifica firma')}}
{{ Form::close() }}

