nds('adm_theme::layouts.app')
@section('page_heading','modifica Categoria Propro')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>



{!! Form::bsOpen($row,'update') !!}
{{ Form::bsText('categoria') }}
{{ Form::bsText('propro') }}
{{ Form::bsText('posfun') }}
{{ Form::bsText('euro_pond') }}
{{ Form::bsText('ptime') }}
{{ Form::bsText('euro') }}
{{ Form::bsText('anno') }}

{{Form::submit('Salva ed esci',['class'=>'submit btn btn-success green-meadow'])}}
{!! Form::close() !!}


@endsection
