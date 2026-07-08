nds('adm_theme::layouts.app')
@section('page_heading','cerca')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

<?php
$routename = Request::route()->getName();
?>
{{-- $routename --}}
{{ Form::open(['route' => $routename ]) }}

{{ method_field('POST') }}
{!! csrf_field() !!}
{{ Form::bsText('mese',$row->mese) }}
{{ Form::bsText('anno',$row->anno) }}
@php
$opts1=[
		'7,77'=>'7,77'
		,'1,2,3,4,5,7,77'=>'1,2,3,4,5,7,77'
		,'77,8'=>'77,8] inserite in assenze e liquidate'
];
$opts2=[
	1=>'1] competenza',
	'2'=>'2] azione'
];

@endphp

{{ Form::bsSelect('stati',$row->stati,['options'=>$opts1]) }}
{{ Form::bsSelect('tipo',$row->tipo,['options'=>$opts2]) }}

{{ Form::bsSubmit('vai') }}
{!! Form::close() !!}
@endsection
