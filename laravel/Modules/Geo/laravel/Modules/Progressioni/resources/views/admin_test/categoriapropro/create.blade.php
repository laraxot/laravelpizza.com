nds('adm_theme::layouts.app')
@section('page_heading','modifica Categoria Propro')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>



{!! Form::bsOpen($row,'create') !!}
{{ Form::bsText('categoria') }}
{{ Form::bsText('lista_propro') }}
{{ Form::bsText('lista_propro_sup') }}
{{ Form::bsText('anno') }}

{{Form::submit('Salva ed esci',['class'=>'submit btn btn-success green-meadow'])}}
{!! Form::close() !!}


@endsection
