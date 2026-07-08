nds('adm_theme::layouts.app')
@section('page_heading','upload a file')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

{!! $caption !!}
<?php
$routename = Request::route()->getName();
?>
{{-- $routename --}}
{{ Form::open(['route' => $routename,'files'=>true]) }}
{{ method_field('POST') }}
{!! csrf_field() !!}
{{-- Form::bsUpload('file_csv',$row->file_csv) --}}
{!! Form::bsUnisharpFileMan('file_csv') !!}
{{ Form::bsSubmit('vai') }}
{!! Form::close() !!}
@endsection
