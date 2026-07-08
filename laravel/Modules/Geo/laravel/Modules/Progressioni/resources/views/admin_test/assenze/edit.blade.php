nds('adm_theme::layouts.app')
@section('page_heading','modifica Codici Assenze')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>



{!! Form::bsOpen($row,'update') !!}
{{ Form::bsInteger('tipo') }}
{{ Form::bsInteger('codice') }}
{{ Form::bsText('descr') }}
{{ Form::bsText('umi') }}
{{ Form::bsDecimal('dur') }}

{{ Form::bsInteger('anno') }}

{{Form::bsSubmit('Salva ed esci')}}
{!! Form::close() !!}


@endsection
