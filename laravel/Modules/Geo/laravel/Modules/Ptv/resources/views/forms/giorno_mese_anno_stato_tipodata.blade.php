nds('adm_theme::layouts.app')
@section('page_heading','filtra')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

{!! $title !!}
<?php
$routename = Request::route()->getName();
?>
{{-- $routename --}}
{{-- Form::open(['route' => $routename]) --}}
{{  Form::model($row) }}

{{ method_field('POST') }}
{!! csrf_field() !!}
{{-- Form::bsText('ente',$row->ente) --}}
{{ Form::bsText('giorno') }}
{{ Form::bsText('mese') }}
{{ Form::bsText('anno') }}
{{ Form::bsSelect('stato',null,$stati->pluck('nome','id') ) }}
{{ Form::bsSelect('tipo',null,[1=>'competenza','2'=>'azione']) }}
{{ Form::bsSubmit('vai') }}
{!! Form::close() !!}
@endsection
