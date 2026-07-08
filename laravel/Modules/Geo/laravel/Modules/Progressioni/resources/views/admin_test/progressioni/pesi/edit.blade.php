nds('adm_theme::layouts.app')
@section('page_heading','modifica Pesi')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>



{!! Form::bsOpen($row,'update') !!}
{{ Form::bsText('lista_propro') }}
{{ Form::bsText('descr') }}
{{ Form::bsText('peso_esperienza_acquisita') }}
{{ Form::bsText('peso_risultati_ottenuti') }}
{{ Form::bsText('peso_arricchimento_professionale') }}
{{ Form::bsText('peso_impegno') }}
{{ Form::bsText('peso_qualita_prestazione') }}
{{ Form::bsText('anno') }}

{{Form::submit('Salva ed esci',['class'=>'submit btn btn-success green-meadow'])}}
{!! Form::close() !!}


@endsection
