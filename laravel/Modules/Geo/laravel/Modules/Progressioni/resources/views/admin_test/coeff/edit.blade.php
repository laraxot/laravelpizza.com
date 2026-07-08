nds('adm_theme::layouts.app')
@section('page_heading','modifica Coeff')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>



{!! Form::bsOpen($row,'update') !!}
{{ Form::bsText('name') }}
{{ Form::bsDecimal('value') }}
{{ Form::bsText('anno') }}

{{Form::bsSubmit('Salva ed esci')}}
{!! Form::close() !!}


@endsection
