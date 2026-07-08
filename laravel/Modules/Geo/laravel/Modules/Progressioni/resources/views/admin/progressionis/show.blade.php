nds('adm_theme::layouts.app')
@section('content')
@php
    //dddx($_panel);
	$anag=$row->anag;
	$lista_codici_aspettative=$row->listaCodiciAspettative();
	$criteri=$row->criteriEsclusione->pluck('value','name');

	$date_max=$row->criteriOptionsArr('data_presenza_al');
    $date_min=$row->criteriOptionsArr('data_presenza_dal');
@endphp
<x-filament::badge> flash-message </x-filament::badge>
{{--
<div class="page-wrapper">
--}}
{!! Theme::include('inner_page',[],get_defined_vars() ) !!}
{{--
    @include('adm_theme::layouts.partials.breadcrumb')
    @include('adm_theme::layouts.partials.tabs',['tabs'=>$_panel->tabs()])
--}}
{{--
<section class="create-page inner-page">
		<div class="container-fluid">
			<div class="row">
--}}

@include($view.'.head')

@foreach($row->coeff()->get() as $kc=>$vc)
	@php
		$sk=$vc->name;
	@endphp
	@if($vc->value!=0 )
		<h3>{{ $sk }}</h3>
		@include($view.'.'.$sk,['scheda'=>$row])
	@endif
{{--
</div>
</div>
</section>
</div>
--}}

@endforeach

@endsection
