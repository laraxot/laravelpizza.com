nds('adm_theme::layouts.app')
@section('page_heading','cerca')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

<?php
$routename = Request::route()->getName();
?>
<p>in lista svocfi mettere le voci stipendio separate con la virgola </p>
{{ Form::open(['route' => $routename ]) }}
{{ method_field('POST') }}
{!! csrf_field() !!}
{{ Form::bsText('lista_svocfi') }}
{{ Form::bsText('anno') }}
{{ Form::bsSelect('tipo',old('tipo'),[1=>'1] competenza','2'=>'2] azione']) }}
{{ Form::bsSubmit('vai') }}
{!! Form::close() !!}
@endsection
