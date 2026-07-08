nds('adm_theme::layouts.app')
@section('page_heading','cerca')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

<?php
$routename = Request::route()->getName();
?>
<p>non lasciare il giorno vuoto.. se non interessa alla query metti 0</p>
{{ $routename }}
{{ Form::open(['route' => $routename ]) }}


{{ method_field('POST') }}
{!! csrf_field() !!}
{{ Form::bsText('giorno',$row->giorno) }}
{{ Form::bsText('mese',$row->mese) }}
{{ Form::bsText('anno',$row->anno) }}
{{ Form::bsSelect('stati',$row->stati,['7,77'=>'7,77','1,2,3,4,5,7,77'=>'1,2,3,4,5,7,77']) }}
{{ Form::bsSelect('tipo',$row->tipo,[1=>'1] competenza','2'=>'2] azione']) }}

{{ Form::bsSubmit('vai') }}
{!! Form::close() !!}
@endsection
