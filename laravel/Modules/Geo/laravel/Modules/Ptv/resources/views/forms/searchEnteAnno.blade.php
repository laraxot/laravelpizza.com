nds('adm_theme::layouts.app')
@section('page_heading','cerca')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

<?php
$routename = Request::route()->getName();
?>
{{-- $routename --}}
{{ Form::open(['route' => $routename]) }}

{{ method_field('POST') }}
{!! csrf_field() !!}
{{ Form::bsText('ente',$row->ente) }}
{{ Form::bsText('anno',$row->anno) }}
{{ Form::bsSubmit('vai') }}
{!! Form::close() !!}
@endsection
