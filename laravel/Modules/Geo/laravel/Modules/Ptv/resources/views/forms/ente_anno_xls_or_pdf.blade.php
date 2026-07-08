nds('adm_theme::layouts.app')
@section('page_heading','cerca')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

<pre>{{ $caption }}</pre>
<?php
$routename = Request::route()->getName();
?>
{{-- $routename --}}
{{ Form::open(['route' => $routename]) }}
{{ method_field('POST') }}
{!! csrf_field() !!}
{{-- Form::bsText('ente',$row->ente) --}}
{{ Form::bsText('ente',$row->ente) }}
{{ Form::bsText('anno',$row->anno) }}

<div class="form-group">
	<label for="ente" class="col-md-4 control-label">out</label>
	<div class="col-md-6">
		<input type="radio" name="out" value="xls">XLS
		<input type="radio" name="out" value="pdf">PDF
	</div>
</div>




{{ Form::bsSubmit('vai') }}
{!! Form::close() !!}
@endsection
