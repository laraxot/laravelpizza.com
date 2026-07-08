nds('adm_theme::layouts.app')
@section('page_heading','conferma azione')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

<pre>{{ $title }}</pre>
<?php
$routename = Request::route()->getName();
?>
{{-- $routename --}}
{{ Form::open(['route' => $routename]) }}
{{ method_field('POST') }}
{!! csrf_field() !!}
{{-- Form::bsText('ente',$row->ente) --}}
{{ Form::label('conferma') }}
{{ Form::checkbox('conferma') }}
{{ Form::bsSubmit('vai') }}
{!! Form::close() !!}
@endsection
