nds('adm_theme::layouts.app')
@section('page_heading','crea Criteri Esclusione')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>



{!! Form::bsOpen($row,'store') !!}
{{ Form::bsInteger('min_gg_posiz_1_in_sede') }}
{{ Form::bsInteger('min_gg_propro') }}
{{ Form::bsInteger('min_gg_propro_posfun') }}
{{ Form::bsInteger('min_gg_anno') }}
{{ Form::bsText('lista_propro_posfun') }}
{{ Form::bsText('lista_propro') }}
{{ Form::bsText('lista_posiz') }}
{{ Form::bsInteger('disci') }}
{{ Form::bsDate('presenti_il_giorno') }}
{{ Form::bsDate('data_presenza_al') }}
{{ Form::bsDate('data_presenza_dal') }}

{{ Form::bsText('anno') }}

{{Form::bsSubmit('Salva ed esci')}}
{!! Form::close() !!}


@endsection
